<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Course;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CourseCatalog extends Component
{
    use WithPagination;

    // Filter properties
    public $search = '';
    public $level = '';           // For single selection (radio)
    public $delivery = '';        // For single selection (radio) 
    public $category = '';        // For single selection (radio)
    public $sortBy = 'latest';
    public $perPage = 12;
    public $minPrice = null;
    public $maxPrice = null;
    public $certification = false;
    public $featured = false;
    public $popular = false;
    
    // Cart properties
    public $cartCount = 0;
    public $cartItems = [];

    // Query string for URL persistence
    protected $queryString = [
        'search' => ['except' => ''],
        'level' => ['except' => ''],
        'delivery' => ['except' => ''],
        'category' => ['except' => ''],
        'sortBy' => ['except' => 'latest'],
        'perPage' => ['except' => 12],
        'minPrice' => ['except' => null],
        'maxPrice' => ['except' => null],
        'certification' => ['except' => false],
        'featured' => ['except' => false],
        'popular' => ['except' => false],
    ];

    /**
     * Initialize component
     */
    public function mount()
    {
        $this->perPage = session('catalog_per_page', 12);
        $this->updateCartData();
        
        // Debug: Log initial state
        Log::info('CourseCatalog mounted', [
            'level' => $this->level,
            'delivery' => $this->delivery,
            'category' => $this->category,
            'search' => $this->search,
        ]);
    }

    /**
     * Update cart data from database
     */
    public function updateCartData()
    {
        if (Auth::check()) {
            $this->cartCount = Cart::where('user_id', Auth::id())->count();
            $this->cartItems = Cart::where('user_id', Auth::id())
                ->pluck('course_id')
                ->toArray();
        }
    }

    /**
     * Add course to cart
     */
    public function addToCart($courseId)
    {
        if (!Auth::check()) {
            $this->dispatch('show-login-modal');
            return;
        }

        $course = Course::findOrFail($courseId);
        
        // Check if already in cart
        $existingCart = Cart::where('user_id', Auth::id())
            ->where('course_id', $courseId)
            ->first();

        if (!$existingCart) {
            Cart::create([
                'user_id' => Auth::id(),
                'course_id' => $courseId,
                'price' => $course->price,
                'discount_price' => $course->discount_price,
            ]);

            $this->updateCartData();
            $this->dispatch('cartUpdated');
            $this->dispatch('notify', [
                'message' => 'Course added to cart successfully!',
                'type' => 'success'
            ]);
        } else {
            $this->dispatch('notify', [
                'message' => 'Course is already in your cart!',
                'type' => 'warning'
            ]);
        }
    }

    /**
     * Remove course from cart
     */
    public function removeFromCart($courseId)
    {
        if (!Auth::check()) {
            $this->dispatch('show-login-modal');
            return;
        }

        Cart::where('user_id', Auth::id())
            ->where('course_id', $courseId)
            ->delete();

        $this->updateCartData();
        $this->dispatch('cartUpdated');
        $this->dispatch('notify', [
            'message' => 'Course removed from cart successfully!',
            'type' => 'success'
        ]);
    }

    /**
     * Handle property updates
     */
    public function updated($property, $value)
    {
        // Debug logging
        Log::info("Property updated: {$property} = " . json_encode($value));
        
        // Reset to first page when filters change (except perPage)
        if (!in_array($property, ['perPage', 'cartCount', 'cartItems'])) {
            $this->resetPage();
        }

        // Save perPage preference to session
        if ($property === 'perPage') {
            session(['catalog_per_page' => $this->perPage]);
        }
    }

    /**
     * Reset all filters
     */
    public function resetFilters()
    {
        $this->reset([
            'search', 
            'level', 
            'delivery',
            'category',
            'sortBy', 
            'minPrice', 
            'maxPrice',
            'certification',
            'featured',
            'popular'
        ]);
        $this->resetPage();
        
        Log::info('Filters reset');
    }

    /**
     * Render the component
     */
    public function render()
    {
        $courses = $this->getCourses();
        
        // Debug: Log query results
        Log::info('Courses fetched', [
            'count' => $courses->count(),
            'filters' => [
                'level' => $this->level,
                'delivery' => $this->delivery,
                'category' => $this->category,
            ]
        ]);
        
        // Mark which courses are in cart
        foreach ($courses as $course) {
            $course->in_cart = in_array($course->id, $this->cartItems);
        }
        
        // Get filter counts
        $filterCounts = $this->getFilterCounts();
        
        // Calculate active filters count
        $activeFiltersCount = $this->countActiveFilters();

        return view('livewire.course-catalog', [
            'courses' => $courses,
            'filterCounts' => $filterCounts,
            'totalCourses' => Course::where('status', 'published')->count(),
            'activeFiltersCount' => $activeFiltersCount,
        ]);
    }

    /**
     * Get filtered courses
     */
    private function getCourses()
    {
        $query = Course::query()
            ->where('status', 'published')
            ->with(['user' => function($query) {
                $query->select('id', 'name', 'email');
            }])
            ->withCount('users as enrollments_count');
        
        // Load reviews average if relationship exists
        if (method_exists(Course::class, 'reviews')) {
            $query->withAvg('reviews', 'rating');
        }

        // === APPLY FILTERS ===
        
        // Apply search
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('short_description', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        // Apply level filter (this field exists in your Course model)
        if (!empty($this->level) && $this->level !== 'latest') {
            $query->where('level', $this->level);
            Log::info("Applying level filter: {$this->level}");
        }

        // Apply delivery filter - TEMPORARY: Check if field exists
        if (!empty($this->delivery) && $this->delivery !== 'latest') {
            // Check if delivery_method field exists in database
            $course = new Course();
            if (isset($course->delivery_method)) {
                $query->where('delivery_method', $this->delivery);
            }
            Log::info("Applying delivery filter: {$this->delivery}");
        }

        // Apply category filter - TEMPORARY: Check if field exists
        if (!empty($this->category) && $this->category !== 'latest') {
            // Check if category field exists in database
            $course = new Course();
            if (isset($course->category)) {
                $query->where('category', $this->category);
            }
            Log::info("Applying category filter: {$this->category}");
        }

        // Apply boolean filters
        if ($this->certification) {
            $query->whereNotNull('certification')
                  ->where('certification', '!=', '');
        }

        if ($this->featured) {
            $query->where('is_featured', true);
        }

        if ($this->popular) {
            $query->where('is_popular', true);
        }

        // Apply price range
        if ($this->minPrice !== null) {
            $query->where('price', '>=', (float) $this->minPrice);
        }

        if ($this->maxPrice !== null) {
            $query->where('price', '<=', (float) $this->maxPrice);
        }

        // === APPLY SORTING ===
        $this->applySorting($query);

        return $query->paginate($this->perPage);
    }

    /**
     * Apply sorting to query
     */
    private function applySorting($query)
    {
        switch ($this->sortBy) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'popular':
                $query->orderBy('enrollments_count', 'desc');
                break;
            case 'rating':
                if (method_exists(Course::class, 'reviews')) {
                    $query->orderBy('reviews_avg_rating', 'desc');
                } else {
                    $query->orderBy('created_at', 'desc');
                }
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;
            default: // 'latest'
                $query->orderBy('created_at', 'desc');
                break;
        }
    }

    /**
     * Get filter counts for display
     */
    private function getFilterCounts()
    {
        return Cache::remember('course_filter_counts', 3600, function () {
            return [
                'beginner' => Course::where('level', 'beginner')->where('status', 'published')->count(),
                'intermediate' => Course::where('level', 'intermediate')->where('status', 'published')->count(),
                'advanced' => Course::where('level', 'advanced')->where('status', 'published')->count(),
                'expert' => Course::where('level', 'expert')->where('status', 'published')->count(),
                'featured' => Course::where('is_featured', true)->where('status', 'published')->count(),
                'popular' => Course::where('is_popular', true)->where('status', 'published')->count(),
                'certified' => Course::whereNotNull('certification')
                    ->where('certification', '!=', '')
                    ->where('status', 'published')
                    ->count(),
                'free' => Course::where('price', 0)->where('status', 'published')->count(),
                'paid' => Course::where('price', '>', 0)->where('status', 'published')->count(),
            ];
        });
    }

    /**
     * Count active filters
     */
    private function countActiveFilters()
    {
        $count = 0;
        
        $filters = [
            'search' => $this->search,
            'level' => $this->level,
            'delivery' => $this->delivery,
            'category' => $this->category,
            'minPrice' => $this->minPrice,
            'maxPrice' => $this->maxPrice,
            'certification' => $this->certification,
            'featured' => $this->featured,
            'popular' => $this->popular,
        ];
        
        foreach ($filters as $filter) {
            if (!empty($filter) && $filter !== false) {
                $count++;
            }
        }
        
        return $count;
    }
}