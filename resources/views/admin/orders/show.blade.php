@extends('layouts.app')

@section('title', 'Order #' . $order->order_number . ' - Admin')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <a href="{{ route('admin.orders.index') }}" class="text-blue-600 hover:underline">← Back to Orders</a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-8">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h1 class="text-2xl font-bold mb-2">Order #{{ $order->order_number }}</h1>
                <p class="text-gray-600">Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}</p>
                <p class="text-gray-600">Customer: {{ $order->user->name }} ({{ $order->user->email }})</p>
            </div>
        </div>

        <!-- Update Status Form -->
        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
            <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}" class="flex items-center gap-4">
                @csrf
                @method('PATCH')
                
                <label for="status" class="font-semibold">Update Status:</label>
                <select name="status" id="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    Update
                </button>
            </form>
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
                            <p class="text-gray-600 text-sm">Quantity: {{ $item->quantity }}</p>
                            <p class="text-gray-600 text-sm">Price: ${{ number_format($item->price, 2) }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-bold">${{ number_format($item->price * $item->quantity, 2) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Customer & Shipping Information -->
        <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h2 class="text-lg font-bold mb-4">Customer Information</h2>
                <div class="space-y-2 text-sm">
                    <p><strong>Name:</strong> {{ $order->customer_name }}</p>
                    <p><strong>Email:</strong> {{ $order->customer_email }}</p>
                    <p><strong>Phone:</strong> {{ $order->customer_phone }}</p>
                </div>
            </div>

            <div>
                <h2 class="text-lg font-bold mb-4">Shipping Address</h2>
                <p class="text-sm">{{ $order->shipping_address }}</p>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="border-t pt-6">
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

        @if($order->notes)
            <div class="border-t pt-6 mt-6">
                <h2 class="text-lg font-bold mb-2">Order Notes</h2>
                <p class="text-gray-700">{{ $order->notes }}</p>
            </div>
        @endif
    </div>
</div>
@endsection
