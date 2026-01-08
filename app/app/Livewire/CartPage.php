<?php

namespace App\Livewire;

use Livewire\Component;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;

class CartPage extends Component
{
    public $cartItems = [];
    public $subTotal = 0;
    public $total = 0;
    public $itemCount = 0;
    
    protected $listeners = ['cartUpdatedGlobally' => 'loadCart'];

    public function mount()
    {
        $this->loadCart();
    }
    
    private function getCartSessionId()
    {
        if (Auth::check()) {
            return 'cart_' . Auth::id();
        }
        return 'cart_' . session()->getId();
    }
    
    public function loadCart()
    {
        try {
            $sessionId = $this->getCartSessionId();
            Cart::session($sessionId);
            
            $this->cartItems = [];
            $cartContent = Cart::getContent();
            
            foreach ($cartContent as $item) {
                $course = Course::find($item->id);
                if ($course) {
                    $this->cartItems[] = [
                        'id' => $item->id,
                        'name' => $item->name,
                        'short_description' => $item->attributes['short_description'],
                        'reviews_avg_rating' => isset($item->attributes['reviews_avg_rating']),
                        'price' => $item->price,
                        'quantity' => $item->quantity,
                        'total' => $item->price * $item->quantity,
                        'course' => $course,
                        'image' => $course->image,
                        'slug' => $course->slug,
                    ];
                }
            }
            
            $this->itemCount = Cart::getTotalQuantity();
            $this->subTotal = Cart::getSubTotal();
            $this->total = Cart::getTotal();
            
        } catch (\Exception $e) {
            $this->cartItems = [];
            $this->itemCount = 0;
            $this->subTotal = 0;
            $this->total = 0;
        }
    }
    
    public function updateQuantity($itemId, $quantity)
    {
        if ($quantity < 1) {
            $this->removeFromCart($itemId);
            return;
        }
        
        try {
            $sessionId = $this->getCartSessionId();
            Cart::session($sessionId);
            
            Cart::update($itemId, [
                'quantity' => [
                    'relative' => false,
                    'value' => $quantity
                ],
            ]);
            
            $this->loadCart();
            $this->dispatch('cartUpdatedGlobally');
            
            session()->flash('message', 'Cart updated successfully.');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update cart.');
        }
    }
    
    public function removeFromCart($courseId)
    {
        try {
            $sessionId = $this->getCartSessionId();
            Cart::session($sessionId);
            Cart::remove($courseId);
            
            $this->loadCart();
            $this->dispatch('cartUpdatedGlobally');
            
            session()->flash('message', 'Item removed from cart.');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to remove item.');
        }
    }
    
    public function clearCart()
    {
        try {
            $sessionId = $this->getCartSessionId();
            Cart::session($sessionId);
            Cart::clear();
            
            $this->loadCart();
            $this->dispatch('cartUpdatedGlobally');
            
            session()->flash('message', 'Cart cleared successfully.');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to clear cart.');
        }
    }
    
    public function render()
    {
        return view('livewire.cart-page');
    }
}