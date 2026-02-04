@extends('layouts.app')

@section('title', $product->name . ' - ShopNow')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8">
            <!-- Product Image -->
            <div class="bg-gray-200 rounded-lg flex items-center justify-center h-96">
                @if($product->image)
                    @if(str_starts_with($product->image, 'http'))
                        <img src="{{ $product->image }}" alt="{{ $product->name }}" class="h-full w-full object-cover rounded-lg">
                    @else
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover rounded-lg">
                    @endif
                @else
                    <span class="text-gray-400 text-9xl">📦</span>
                @endif
            </div>

            <!-- Product Details -->
            <div>
                <nav class="text-sm text-gray-500 mb-4">
                    <a href="{{ route('products.index') }}" class="hover:text-blue-600">Products</a>
                    <span class="mx-2">/</span>
                    <a href="{{ route('products.index', ['category' => $product->category_id]) }}" class="hover:text-blue-600">
                        {{ $product->category->name }}
                    </a>
                </nav>

                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $product->name }}</h1>
                <p class="text-gray-600 mb-2">{{ $product->category->name }}</p>
                
                @if($product->seller)
                    <div class="flex items-center space-x-2 mb-4 p-3 bg-gray-50 rounded-lg border border-gray-200">
                        <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                            {{ substr($product->seller->shop_name ?? $product->seller->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Shop Name</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $product->seller->shop_name ?? $product->seller->name }}</p>
                        </div>
                    </div>
                @endif
                
                <div class="mb-6">
                    <span class="text-4xl font-bold text-blue-600">${{ number_format($product->price, 2) }}</span>
                </div>

                <div class="mb-6">
                    <h3 class="font-semibold text-gray-900 mb-2">Description</h3>
                    <p class="text-gray-700">{{ $product->description ?? 'No description available.' }}</p>
                </div>

                <div class="mb-6">
                    <span class="text-sm font-medium text-gray-700">
                        Availability: 
                        @if($product->stock > 0)
                            <span class="text-green-600">In Stock ({{ $product->stock }} available)</span>
                        @else
                            <span class="text-red-600">Out of Stock</span>
                        @endif
                    </span>
                </div>

                <!-- Add to Cart Form -->
                @if($product->stock > 0)
                    @auth
                        <div x-data="{ quantity: 1 }" class="space-y-4">
                            <div>
                                <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
                                <div class="flex items-center space-x-3">
                                    <button type="button" @click="quantity = Math.max(1, quantity - 1)"
                                        class="bg-gray-200 px-4 py-2 rounded-lg hover:bg-gray-300 transition">
                                        -
                                    </button>
                                    <input type="number" x-model="quantity" min="1" max="{{ $product->stock }}"
                                        class="w-20 text-center border border-gray-300 rounded-lg py-2 text-sm">
                                    <button type="button" @click="quantity = Math.min({{ $product->stock }}, quantity + 1)"
                                        class="bg-gray-200 px-4 py-2 rounded-lg hover:bg-gray-300 transition">
                                        +
                                    </button>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <form method="POST" action="{{ route('cart.add', $product) }}">
                                    @csrf
                                    <input type="hidden" name="quantity" x-bind:value="quantity">
                                    <button type="submit" 
                                        class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition font-semibold flex items-center justify-center space-x-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                        <span>Add to Cart</span>
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('cart.add', $product) }}">
                                    @csrf
                                    <input type="hidden" name="quantity" x-bind:value="quantity">
                                    <input type="hidden" name="buy_now" value="1">
                                    <button type="submit" 
                                        class="w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 transition font-semibold flex items-center justify-center space-x-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                        </svg>
                                        <span>Buy Now</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" 
                            class="block w-full bg-blue-600 text-white text-center py-3 rounded-lg hover:bg-blue-700 transition font-semibold">
                            Login to Purchase
                        </a>
                    @endauth
                @else
                    <button disabled class="w-full bg-gray-400 text-white py-3 rounded-lg cursor-not-allowed">
                        Out of Stock
                    </button>
                @endif

                <a href="{{ route('products.index') }}" class="block mt-4 text-center text-blue-600 hover:underline">
                    ← Continue Shopping
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
