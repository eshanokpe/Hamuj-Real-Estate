<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Review;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CourseShow extends Component
{
    public $course;
    public $slug;
    public $reviews;
    public $averageRating = 0;
    public $totalReviews = 0;
    public $inCart = false;
    public $enrolled = false;
    public $enrollment;
    public $progress = 0;
    
    // Review form
    public $reviewText = '';
    public $rating = 5;
    public $showReviewForm = false;
    
    // Course details
    public $showFullDescription = false;
    public $selectedTab = 'overview';
    public $showCurriculum = false;
    
    // Related courses
    public $relatedCourses = [];
    
    public function mount($slug)
    {
        $this->slug = $slug;
        $this->loadCourse();
        
        if (Auth::check()) {
            $this->checkCartStatus();
            $this->checkEnrollmentStatus();
        }
    }
    
    public function loadCourse()
    {
        $this->course = Course::with([
            'modules' => function($query) {
                $query->orderBy('order');
            },
            'modules.lessons' => function($query) {
                $query->orderBy('order');
            },
            'instructor',
            'reviews.user',
            // 'category',
            // 'prerequisites',
            // 'outcomes'
        ])
        ->withCount(['modules', 'lessons', 'enrollments', 'reviews'])
        ->withAvg('reviews', 'rating')
        ->where('slug', $this->slug)
        ->where('status', 'published')
        ->firstOrFail();
        
        // Load reviews
        $this->reviews = $this->course->reviews()
            ->with('user')
            ->latest()
            ->take(5)
            ->get();
        
        $this->averageRating = $this->course->reviews_avg_rating ?? 0;
        $this->totalReviews = $this->course->reviews_count ?? 0;
        
        // Load related courses
        $this->loadRelatedCourses();
    }
    
    public function loadRelatedCourses()
    {
        $this->relatedCourses = Course::where('id', $this->course->category_id)
            // ->where('id', '!=', $this->course->id)
            ->where('status', 'published')
            ->inRandomOrder()
            ->limit(3)
            ->get()
            ->map(function ($course) {
                $course->in_cart = $this->checkIfInCart($course->id);
                return $course;
            });
    }
    
    public function checkCartStatus()
    {
        $sessionId = 'cart_' . Auth::id();
        $cart = Cart::session($sessionId);
        $this->inCart = $cart->get($this->course->id) ? true : false;
    }
    
    public function checkEnrollmentStatus()
    {
        $this->enrollment = Enrollment::where('user_id', Auth::id())
            ->where('course_id', $this->course->id)
            ->first();
        
        $this->enrolled = !is_null($this->enrollment);
        
        if ($this->enrolled) {
            $this->calculateProgress();
        }
    }
    
    public function calculateProgress()
    {
        if ($this->enrolled && $this->course->modules_count > 0) {
            $completedLessons = Auth::user()->completedLessons()
                ->whereHas('module', function($query) {
                    $query->where('course_id', $this->course->id);
                })
                ->count();
            
            $totalLessons = $this->course->lessons_count;
            $this->progress = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0;
        }
    }
    
    public function checkIfInCart($courseId)
    {
        if (Auth::check()) {
            $sessionId = 'cart_' . Auth::id();
            $cart = Cart::session($sessionId);
            return $cart->get($courseId) ? true : false;
        }
        return false;
    }
    
    public function addToCart()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        try {
            $sessionId = 'cart_' . Auth::id();
            $cart = Cart::session($sessionId);
            
            // Check if already in cart
            if ($cart->get($this->course->id)) {
                $this->dispatch('notify', [
                    'type' => 'warning',
                    'message' => 'This course is already in your cart!'
                ]);
                return;
            }
            
            // Add to cart
            $cart->add([
                'id' => $this->course->id,
                'name' => $this->course->title,
                'price' => $this->course->current_price,
                'quantity' => 1,
                'attributes' => [
                    'slug' => $this->course->slug,
                    'image' => $this->course->image,
                    'level' => $this->course->level,
                    'duration' => $this->course->duration,
                    'format' => $this->course->format,
                    'instructor' => $this->course->instructor->name ?? 'IGRCFP',
                    'original_price' => $this->course->price,
                    'discount_price' => $this->course->discount_price,
                    'has_discount' => $this->course->has_discount,
                ],
                'associatedModel' => Course::class
            ]);
            
            $this->inCart = true;
            $this->dispatch('cartUpdatedGlobally');
            
            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Course added to cart successfully!'
            ]);
            
        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Failed to add course to cart. Please try again.'
            ]);
        }
    }
    
    public function removeFromCart()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        try {
            $sessionId = 'cart_' . Auth::id();
            $cart = Cart::session($sessionId);
            $cart->remove($this->course->id);
            
            $this->inCart = false;
            $this->dispatch('cartUpdatedGlobally');
            
            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Course removed from cart!'
            ]);
            
        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Failed to remove course from cart.'
            ]);
        }
    }
    
    public function enrollCourse()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        // Check if already enrolled
        if ($this->enrolled) {
            return redirect()->route('learner.courses.learn', $this->course->slug);
        }
        
        // Create enrollment
        Enrollment::create([
            'user_id' => Auth::id(),
            'course_id' => $this->course->id,
            'status' => 'active',
            'enrolled_at' => now(),
        ]);
        
        $this->enrolled = true;
        $this->enrollment = Enrollment::where('user_id', Auth::id())
            ->where('course_id', $this->course->id)
            ->first();
        
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Successfully enrolled in the course!'
        ]);
        
        // Redirect to learning page
        return redirect()->route('learner.courses.learn', $this->course->slug);
    }
    
    public function submitReview()
    {
        $this->validate([
            'rating' => 'required|integer|between:1,5',
            'reviewText' => 'required|min:10|max:1000',
        ]);
        
        Review::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'course_id' => $this->course->id,
            ],
            [
                'rating' => $this->rating,
                'comment' => $this->reviewText,
                'status' => 'approved',
            ]
        );
        
        // Reset form
        $this->reviewText = '';
        $this->rating = 5;
        $this->showReviewForm = false;
        
        // Reload course data
        $this->loadCourse();
        
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Review submitted successfully!'
        ]);
    }
    
    public function toggleTab($tab)
    {
        $this->selectedTab = $tab;
    }
    
    public function toggleCurriculum()
    {
        $this->showCurriculum = !$this->showCurriculum;
    }
    
    public function render()
    {
        return view('livewire.course-show')
            ->layout('layouts.app');
    }
}