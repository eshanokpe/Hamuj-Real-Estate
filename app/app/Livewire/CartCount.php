<?php

namespace App\Livewire;

use Livewire\Component;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\Auth;

class CartCount extends Component
{
    public $count = 0;
    public $total = 0;
    
    // Listen for cart updates from PopularCourses component
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
            
            $this->count = Cart::getTotalQuantity();
            $this->total = Cart::getTotal();
            
        } catch (\Exception $e) {
            $this->count = 0;
            $this->total = 0;
        }
    }

    public function render()
    {
        return view('livewire.cart-count');
    }
}