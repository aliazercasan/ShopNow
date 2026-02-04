@extends('layouts.app')

@section('title', 'Products - ShopNow')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col md:flex-row gap-6">
        <!-- Sidebar Filters -->
        <aside class="w-full md:w-64 flex-shrink-0">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold mb-4">Filters</h3>
                
                <!-- Search -->
                <form method="GET" action="{{ route('products.index') }}" class="mb-6">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <button type="submit" class="w-full mt-2 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                        Search
                    </button>
                </form>
                
                <!-- Categories -->
                <div>
                    <h4 class="font-semibold mb-2">Categories</h4>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('products.index') }}" 
                                class="text-gray-700 hover:text-blue-600 {{ !request('category') ? 'font-bold text-blue-600' : '' }}">
                                All Products
                            </a>
                        </li>
                        @foreach($categories as $category)
                            <li>
                                <a href="{{ route('products.index', ['category' => $category->id]) }}" 
                                    class="text-gray-700 hover:text-blue-600 {{ request('category') == $category->id ? 'font-bold text-blue-600' : '' }}">
                                    {{ $category->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </aside>

        <!-- Products Grid -->
        <div class="flex-1">
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900">Products</h1>
                <p class="text-gray-600 mt-2">{{ $products->total() }} products found</p>
            </div>

            @if($products->isEmpty())
                <div class="bg-white rounded-lg shadow-md p-12 text-center">
                    <p class="text-gray-500 text-lg">No products found.</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($products as $product)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                            <a href="{{ route('products.show', $product) }}">
                                <div class="h-48 bg-gray-200 flex items-center justify-center">
                                    @if($product->image)
                                        @if(str_starts_with($product->image, 'http'))
                                            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                                        @else
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                                        @endif
                                    @else
                                        <span class="text-gray-400 text-4xl">📦</span>
                                    @endif
                                </div>
                            </a>
                            
                            <div class="p-4">
                                <a href="{{ route('products.show', $product) }}">
                                    <h3 class="font-bold text-lg mb-2 hover:text-blue-600">{{ $product->name }}</h3>
                                </a>
                                <p class="text-gray-600 text-sm mb-1">{{ $product->category->name }}</p>
                                
                                @if($product->seller)
                                    <div class="flex items-center space-x-1 mb-2">
                                        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                        <span class="text-xs text-gray-500">{{ $product->seller->shop_name ?? $product->seller->name }}</span>
                                    </div>
                                @endif
                                
                                <p class="text-gray-700 text-sm mb-4 line-clamp-2">{{ $product->description }}</p>
                                
                                <div class="flex items-center justify-between">
                                    <span class="text-2xl font-bold text-blue-600">${{ number_format($product->price, 2) }}</span>
                                    <span class="text-sm text-gray-500">Stock: {{ $product->stock }}</span>
                                </div>
                                
                                @auth
                                    <a href="{{ route('products.show', $product) }}" 
                                        class="mt-4 block w-full bg-blue-600 text-white text-center py-2 rounded-lg hover:bg-blue-700 transition">
                                        View Details
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" 
                                        class="mt-4 block w-full bg-blue-600 text-white text-center py-2 rounded-lg hover:bg-blue-700 transition">
                                        Login to Purchase
                                    </a>
                                @endauth
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
