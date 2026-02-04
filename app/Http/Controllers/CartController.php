<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = $this->getCartItems();
        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        if ($product->stock < $validated['quantity']) {
            return back()->with('error', 'Insufficient stock available.');
        }

        $cartItem = CartItem::where([
            'product_id' => $product->id,
            'user_id' => Auth::id(),
        ])->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $validated['quantity'];
            if ($product->stock < $newQuantity) {
                return back()->with('error', 'Insufficient stock available.');
            }
            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            CartItem::create([
                'user_id' => Auth::id(),
                'session_id' => null,
                'product_id' => $product->id,
                'quantity' => $validated['quantity'],
            ]);
        }

        // If "Buy Now" was clicked, redirect to checkout
        if ($request->has('buy_now')) {
            return redirect()->route('orders.checkout')->with('success', 'Product added! Complete your purchase below.');
        }

        return back()->with('success', 'Product added to cart!');
    }

    public function update(Request $request, CartItem $cartItem)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        if ($cartItem->product->stock < $validated['quantity']) {
            return back()->with('error', 'Insufficient stock available.');
        }

        $cartItem->update(['quantity' => $validated['quantity']]);

        return back()->with('success', 'Cart updated!');
    }

    public function remove(CartItem $cartItem)
    {
        $cartItem->delete();
        return back()->with('success', 'Item removed from cart!');
    }

    private function getCartItems()
    {
        return CartItem::with('product')->where('user_id', Auth::id())->get();
    }
}
