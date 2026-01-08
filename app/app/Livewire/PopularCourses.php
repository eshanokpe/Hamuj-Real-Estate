<?php

namespace App\Livewire;

use Livewire\Component; 
use App\Models\Course;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PopularCourses extends Component
{
    public $courses = [];
    
    public function mount()
    {
        Log::info('🎯 PopularCourses Component Mounted');
        $this->loadPopularCourses();
    }

    private function getCartSessionId()
    {
        if (Auth::check()) {
            return 'cart_' . Auth::id();
        }
        return 'cart_' . session()->getId();
    }

    private function initializeCart()
    {
        $sessionId = $this->getCartSessionId();
        Cart::session($sessionId);
        return Cart::session($sessionId);
    }

    public function loadPopularCourses()
    {
        try {
            Log::info('🔄 Loading popular courses...');
            
            $courses = Course::where('is_popular', true)
                ->where('status', 'published')
                ->latest()
                ->take(4)
                ->get();

            $this->courses = $courses->map(function ($course) {
                $inCart = $this->checkIfInCart($course->id);
                
                return [
                    'id' => $course->id,
                    'title' => $course->title,
                    'short_description' => $course->short_description,
                    'price' => $course->price,
                    'image' => $course->image,
                    'slug' => $course->slug,
                    'level' => $course->level,
                    'duration' => $course->duration,
                    'format' => $course->format,
                    'certification' => $course->certification,
                    'has_discount' => $course->has_discount,
                    'discount_price' => $course->discount_price,
                    'in_cart' => $inCart,
                    'reviews_avg_rating' => $course->reviews_avg_rating ?? 0,
                ];
            })->toArray();
            
            Log::info('✅ Courses loaded: ' . count($this->courses));
            
        } catch (\Exception $e) {
            Log::error('❌ Error loading courses: ' . $e->getMessage());
            $this->courses = [];
        }
    }

    private function checkIfInCart($courseId)
    {
        try {
            $cart = $this->initializeCart();
            $item = $cart->get($courseId);
            $inCart = !is_null($item);
            Log::info("📦 Course {$courseId} in cart: " . ($inCart ? 'YES' : 'NO'));
            return $inCart;
        } catch (\Exception $e) {
            Log::error('❌ Cart check error: ' . $e->getMessage());
            return false;
        }
    }

    public function addToCart($courseId)
    {
        Log::info('🛒 === ADD TO CART CLICKED ===');
        Log::info('Course ID: ' . $courseId);
        Log::info('User authenticated: ' . (Auth::check() ? 'YES' : 'NO'));
        
        // Check if user is authenticated
        if (!Auth::check()) {
            Log::info('🔒 User not authenticated, redirecting to login');
            $this->dispatch('show-login-modal');
            return;
        }

        try {
            $course = Course::findOrFail($courseId);
            Log::info('📚 Course found: ' . $course->short_description);
            
            $cart = $this->initializeCart();
            
            // Check if course is already in cart
            if ($cart->get($courseId)) {
                Log::info('⚠️ Course already in cart');
                $this->dispatch('notify', 
                    type: 'warning',
                    message: 'This course is already in your cart!'
                );
                return;
            }

            // Add to cart
            Log::info('➕ Adding course to cart...');
            $cart->add([
                'id' => $course->id,
                'name' => $course->title,
                'price' => $course->price,
                'quantity' => 1,
                'attributes' => [
                    'slug' => $course->slug,
                    'image' => $course->image,
                    'level' => $course->level,
                    'duration' => $course->duration,
                    'original_price' => $course->price,
                    'discount_price' => $course->discount_price,
                    'has_discount' => $course->has_discount,
                    'short_description' => $course->short_description,
                    'reviews_avg_rating' => $course->reviews_avg_rating ?? 0,
                ],
                'associatedModel' => Course::class
            ]);
            
            Log::info('✅ Course added to cart');
            
            // Force reload courses with updated in_cart status
            $this->loadPopularCourses();

             // ====== ADD THIS ======
            // Dispatch event to notify other components that cart was updated
            $this->dispatch('cartUpdated');
            
            // Also dispatch for JavaScript listeners
            $this->dispatch('cart-item-added', courseId: $courseId);

            // Show success message
            Log::info('📢 Dispatching success notification');
            $this->dispatch('notify', 
                type: 'success',
                message: 'Course added to cart!'
            );

        } catch (\Exception $e) {
            Log::error('❌ Add to cart error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            $this->dispatch('notify', 
                type: 'error',
                message: 'Failed to add course to cart. Please try again.'
            );
        }
    }

    public function removeFromCart($courseId)
    {
        Log::info('🗑️ === REMOVE FROM CART CLICKED ===');
        Log::info('Course ID: ' . $courseId);
        
        try {
            $cart = $this->initializeCart();
            
            // Remove item from cart
            $cart->remove($courseId);
            Log::info('✅ Course removed from cart');
            
            // Force reload courses with updated in_cart status
            $this->loadPopularCourses();

            // ====== ADD THIS ======
            // Dispatch event to notify other components that cart was updated
            $this->dispatch('cartUpdated');
            
            // Also dispatch for JavaScript listeners
            $this->dispatch('cart-item-removed', courseId: $courseId);


            $this->dispatch('notify', 
                type: 'success',
                message: 'Course removed from cart!'
            );

        } catch (\Exception $e) {
            Log::error('❌ Remove from cart error: ' . $e->getMessage());
            
            $this->dispatch('notify', 
                type: 'error',
                message: 'Failed to remove course from cart.'
            );
        }
    }

    public function render()
    {
        Log::info('🎨 Rendering PopularCourses component');
        return view('livewire.popular-courses');
    }
}