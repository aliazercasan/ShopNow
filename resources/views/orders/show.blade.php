@extends('layouts.app')

@section('title', 'Order #' . $order->order_number . ' - ShopNow')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <a href="{{ route('orders.index') }}" class="text-blue-600 hover:underline">← Back to Orders</a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-8">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h1 class="text-2xl font-bold mb-2">Order #{{ $order->order_number }}</h1>
                <p class="text-gray-600">Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}</p>
            </div>
            <span class="px-4 py-2 rounded-full text-sm font-semibold
                @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                @elseif($order->status === 'completed') bg-green-100 text-green-800
                @else bg-red-100 text-red-800
                @endif">
                {{ ucfirst($order->status) }}
            </span>
        </div>

        <!-- Order Items -->
        <div class="mb-6">
            <h2 class="text-lg font-bold mb-4">Order Items</h2>
            <div class="space-y-4">
                @foreach($order->orderItems as $item)
                    <div class="flex items-center gap-4 border-b pb-4">
                        <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center flex-shrink-0">
                            @if($item->product->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover rounded-lg">
                            @else
                                <span class="text-gray-400 text-2xl">📦</span>
                            @endif
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold">{{ $item->product->name }}</h3>
                            @if($item->product->seller)
                                <p class="text-gray-500 text-xs flex items-center space-x-1 mt-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                    <span>{{ $item->product->seller->shop_name ?? $item->product->seller->name }}</span>
                                </p>
                            @endif
                            <p class="text-gray-600 text-sm mt-1">Quantity: {{ $item->quantity }}</p>
                            <p class="text-gray-600 text-sm">Price: ${{ number_format($item->price, 2) }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-bold">${{ number_format($item->price * $item->quantity, 2) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Shipping Information -->
        <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h2 class="text-lg font-bold mb-4">Shipping Information</h2>
                <div class="space-y-2 text-sm">
                    <p><strong>Name:</strong> {{ $order->customer_name }}</p>
                    <p><strong>Email:</strong> {{ $order->customer_email }}</p>
                    <p><strong>Phone:</strong> {{ $order->customer_phone }}</p>
                    <p><strong>Address:</strong><br>{{ $order->shipping_address }}</p>
                </div>
            </div>

            <div>
                <h2 class="text-lg font-bold mb-4">Order Summary</h2>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-semibold">${{ number_format($order->total_amount, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Shipping</span>
                        <span class="font-semibold">Free</span>
                    </div>
                    <div class="border-t pt-2 mt-2">
                        <div class="flex justify-between text-lg font-bold">
                            <span>Total</span>
                            <span class="text-blue-600">${{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($order->notes)
            <div class="border-t pt-6">
                <h2 class="text-lg font-bold mb-2">Order Notes</h2>
                <p class="text-gray-700">{{ $order->notes }}</p>
            </div>
        @endif
    </div>
</div>
@endsection
