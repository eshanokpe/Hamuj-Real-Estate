<?php

namespace App\Livewire;

use Livewire\Component;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;

class CartDropdown extends Component
{
    public $items = [];
    public $total = 0;
    public $count = 0;
    
   protected $listeners = [
        'cartUpdated' => 'updateCart',
        'cart-item-added' => 'updateCart',
        'cart-item-removed' => 'updateCart'
    ];

    public function mount()
    {
        $this->updateCart();
    }

    private function getCartSessionId()
    {
        if (Auth::check()) {
            return 'cart_' . Auth::id();
        }
        return 'cart_' . session()->getId();
    }

    public function updateCart()
    {
        try {
            $sessionId = $this->getCartSessionId();
            Cart::session($sessionId);
            
            $cartItems = Cart::getContent();
            $this->items = [];
            
            foreach ($cartItems as $item) {
                $course = Course::find($item->id);
                if ($course) {
                    $this->items[] = [
                        'id' => $item->id,
                        'name' => $item->name,
                        'price' => $item->price,
                        'quantity' => $item->quantity,
                        'image' => $course->image,
                        'slug' => $course->slug,
                        'total' => $item->price * $item->quantity
                    ];
                }
            }
            
            $this->count = Cart::getTotalQuantity();
            $this->total = Cart::getTotal();
            
        } catch (\Exception $e) {
            $this->items = [];
            $this->count = 0;
            $this->total = 0;
        }
    }

    public function removeItem($itemId)
    {
        try {
            $sessionId = $this->getCartSessionId();
            Cart::session($sessionId);
            Cart::remove($itemId);
            
            $this->updateCart();
            
            // Notify other components
            $this->dispatch('cartUpdated');
            
            // Show notification
            $this->dispatch('notify', 
                type: 'success',
                message: 'Item removed from cart'
            );
            
        } catch (\Exception $e) {
            $this->dispatch('notify', 
                type: 'error',
                message: 'Failed to remove item'
            );
        }
    }

    public function render()
    {
        return view('livewire.cart-dropdown');
    }
}