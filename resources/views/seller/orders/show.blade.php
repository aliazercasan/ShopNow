@extends('layouts.app')

@section('title', 'Order Details - Seller')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">
    <div class="mb-6">
        <a href="{{ route('seller.orders.index') }}" class="inline-flex items-center text-green-600 hover:text-green-700 font-medium">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Orders
        </a>
    </div>

    <div class="bg-white rounded-lg shadow border border-gray-100 p-6 mb-6">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Order #{{ $order->id }}</h1>
                <p class="text-gray-600 text-sm mt-1">Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}</p>
            </div>
            <div>
                @if($order->status === 'pending')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                        Pending
                    </span>
                @elseif($order->status === 'processing')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                        Processing
                    </span>
                @elseif($order->status === 'shipped')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                        Shipped
                    </span>
                @elseif($order->status === 'delivered')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                        Delivered
                    </span>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                        Cancelled
                    </span>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-2 gap-6 mb-6">
            <div>
                <h3 class="text-sm font-semibold text-gray-700 mb-2">Customer Information</h3>
                <p class="text-sm text-gray-900">{{ $order->user->name }}</p>
                <p class="text-sm text-gray-600">{{ $order->user->email }}</p>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-gray-700 mb-2">Shipping Address</h3>
                <p class="text-sm text-gray-900">{{ $order->shipping_address }}</p>
            </div>
        </div>

        <div class="border-t border-gray-200 pt-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Your Products in this Order</h3>
            <div class="space-y-4">
                @foreach($sellerOrderItems as $item)
                    <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                        @if($item->product->image)
                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-16 h-16 rounded object-cover">
                        @else
                            <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                        <div class="flex-1">
                            <h4 class="text-sm font-medium text-gray-900">{{ $item->product->name }}</h4>
                            <p class="text-xs text-gray-600 mt-1">Quantity: {{ $item->quantity }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-semibold text-gray-900">${{ number_format($item->price, 2) }}</p>
                            <p class="text-xs text-gray-600">each</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-gray-900">${{ number_format($item->price * $item->quantity, 2) }}</p>
                            <p class="text-xs text-gray-600">total</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6 pt-6 border-t border-gray-200">
                <div class="flex justify-end">
                    <div class="w-64">
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-gray-600">Subtotal:</span>
                            <span class="font-semibold text-gray-900">${{ number_format($sellerOrderItems->sum(fn($item) => $item->price * $item->quantity), 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 pt-6 border-t border-gray-200">
            <h3 class="text-sm font-semibold text-gray-700 mb-3">Update Order Status</h3>
            <form method="POST" action="{{ route('seller.orders.updateStatus', $order) }}" class="flex items-center space-x-3">
                @csrf
                @method('PATCH')
                <select name="status" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent text-sm">
                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium text-sm">
                    Update Status
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
