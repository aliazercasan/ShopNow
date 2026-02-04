@extends('layouts.app')

@section('title', 'My Orders - ShopNow')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">My Orders</h1>

    @if($orders->isEmpty())
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <p class="text-gray-500 text-lg mb-4">You haven't placed any orders yet</p>
            <a href="{{ route('products.index') }}" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">
                Start Shopping
            </a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($orders as $order)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-bold">Order #{{ $order->order_number }}</h3>
                            <p class="text-gray-600 text-sm">Placed on {{ $order->created_at->format('M d, Y') }}</p>
                        </div>
                        <div class="mt-2 md:mt-0">
                            <span class="px-4 py-2 rounded-full text-sm font-semibold
                                @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                @elseif($order->status === 'completed') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                    </div>

                    <div class="border-t pt-4">
                        <div class="space-y-2">
                            @foreach($order->orderItems as $item)
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-700">{{ $item->product->name }} x{{ $item->quantity }}</span>
                                    <span class="font-semibold">${{ number_format($item->price * $item->quantity, 2) }}</span>
                                </div>
                            @endforeach
                        </div>

                        <div class="border-t mt-4 pt-4 flex justify-between items-center">
                            <span class="text-lg font-bold">Total: <span class="text-blue-600">${{ number_format($order->total_amount, 2) }}</span></span>
                            <a href="{{ route('orders.show', $order) }}" class="text-blue-600 hover:underline">View Details →</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
