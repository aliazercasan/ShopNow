@extends('layouts.app')

@section('title', 'Shopping Cart - ShopNow')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Shopping Cart</h1>

    @if($cartItems->isEmpty())
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <p class="text-gray-500 text-lg mb-4">Your cart is empty</p>
            <a href="{{ route('products.index') }}" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">
                Continue Shopping
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Cart Items -->
            <div class="lg:col-span-2 space-y-4">
                @foreach($cartItems as $item)
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center gap-6">
                            <!-- Product Image -->
                            <div class="w-24 h-24 bg-gray-200 rounded-lg flex items-center justify-center flex-shrink-0">
                                @if($item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover rounded-lg">
                                @else
                                    <span class="text-gray-400 text-2xl">📦</span>
                                @endif
                            </div>

                            <!-- Product Details -->
                            <div class="flex-1">
                                <h3 class="font-bold text-lg mb-1">
                                    <a href="{{ route('products.show', $item->product) }}" class="hover:text-blue-600">
                                        {{ $item->product->name }}
                                    </a>
                                </h3>
                                <p class="text-gray-600 text-sm mb-2">{{ $item->product->category->name }}</p>
                                <p class="text-blue-600 font-bold">${{ number_format($item->product->price, 2) }}</p>
                            </div>

                            <!-- Quantity Controls -->
                            <div x-data="{ quantity: {{ $item->quantity }} }">
                                <form method="POST" action="{{ route('cart.update', $item) }}" class="flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    
                                    <button type="button" @click="quantity = Math.max(1, quantity - 1); $el.closest('form').submit()"
                                        class="bg-gray-200 px-3 py-1 rounded hover:bg-gray-300">
                                        -
                                    </button>
                                    <input type="number" name="quantity" x-model="quantity" min="1" max="{{ $item->product->stock }}"
                                        class="w-16 text-center border border-gray-300 rounded py-1">
                                    <button type="button" @click="quantity = Math.min({{ $item->product->stock }}, quantity + 1); $el.closest('form').submit()"
                                        class="bg-gray-200 px-3 py-1 rounded hover:bg-gray-300">
                                        +
                                    </button>
                                </form>
                            </div>

                            <!-- Subtotal & Remove -->
                            <div class="text-right">
                                <p class="font-bold text-lg mb-2">${{ number_format($item->product->price * $item->quantity, 2) }}</p>
                                <form method="POST" action="{{ route('cart.remove', $item) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm">Remove</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                    <h2 class="text-xl font-bold mb-4">Order Summary</h2>
                    
                    <div class="space-y-2 mb-4">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-semibold">${{ number_format($total, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Shipping</span>
                            <span class="font-semibold">Free</span>
                        </div>
                        <div class="border-t pt-2 mt-2">
                            <div class="flex justify-between text-lg font-bold">
                                <span>Total</span>
                                <span class="text-blue-600">${{ number_format($total, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    @auth
                        <a href="{{ route('orders.checkout') }}" 
                            class="block w-full bg-blue-600 text-white text-center py-3 rounded-lg hover:bg-blue-700 transition font-semibold">
                            Proceed to Checkout
                        </a>
                    @endauth

                    <a href="{{ route('products.index') }}" class="block mt-4 text-center text-blue-600 hover:underline">
                        ← Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
