<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    private function setCartInstance()
    {
        if (Auth::check()) {
            $cartSessionId = 'cart_' . Auth::id();
        } else {
            $cartSessionId = 'cart_' . session()->getId();
        }
        
        Cart::session($cartSessionId);
    }

    public function index()
    {
        $this->setCartInstance();
        // Return as collection/objects, not array
        $cartItems = Cart::getContent()->sortBy('id');
        $subTotal = Cart::getSubTotal();
        $total = Cart::getTotal();
        
        return view('learner.cart.index', compact('cartItems', 'subTotal', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
        ]);

        $course = Course::findOrFail($request->course_id);
        
        $this->setCartInstance();

        // Check if already in cart
        if (Cart::get($course->id)) {
            return back()->with('warning', 'Course is already in your cart.');
        }

        // Add to cart
        Cart::add([
            'id' => $course->id,
            'name' => $course->short_title ?? $course->title,
            'price' => $course->current_price,
            'quantity' => 1,
            'attributes' => [
                'slug' => $course->slug,
                'image' => $course->image,
                'level' => $course->level,
                'duration' => $course->duration,
                'original_price' => $course->price,
                'discount_price' => $course->discount_price,
                'has_discount' => $course->has_discount,
            ],
            'associatedModel' => Course::class
        ]);

        return back()->with('success', 'Course added to cart successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $this->setCartInstance();
        Cart::update($id, [
            'quantity' => [
                'relative' => false,
                'value' => $request->quantity
            ],
        ]);

        return back()->with('success', 'Cart updated successfully.');
    }

    public function destroy($id)
    {
        $this->setCartInstance();
        Cart::remove($id);

        return back()->with('success', 'Item removed from cart.');
    }

    public function clear()
    {
        $this->setCartInstance();
        Cart::clear();

        return back()->with('success', 'Cart cleared successfully.');
    }
}