@extends('layouts.app')

@section('title', 'My Orders - Seller')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Customer Orders</h1>
        <p class="text-gray-600 text-sm mt-1">Track and manage orders for your products</p>
    </div>

    @if($orders->isEmpty())
        <div class="bg-white rounded-lg shadow border border-gray-100 p-12 text-center">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <p class="text-gray-600 text-lg mb-2 font-medium">No orders yet</p>
            <p class="text-gray-500 text-sm">Orders containing your products will appear here</p>
        </div>
    @else
        <div class="bg-white rounded-lg shadow border border-gray-100 overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Order ID</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Items</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Date</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($orders as $order)
                        @php
                            $sellerItems = $order->orderItems->filter(fn($item) => $item->product->seller_id === auth()->id());
                            $sellerTotal = $sellerItems->sum(fn($item) => $item->price * $item->quantity);
                        @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                #{{ $order->id }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $order->user->name }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $sellerItems->count() }} item(s)
                            </td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                                ${{ number_format($sellerTotal, 2) }}
                            </td>
                            <td class="px-6 py-4">
                                @if($order->status === 'pending')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Pending
                                    </span>
                                @elseif($order->status === 'processing')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        Processing
                                    </span>
                                @elseif($order->status === 'shipped')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                        Shipped
                                    </span>
                                @elseif($order->status === 'delivered')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Delivered
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Cancelled
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $order->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 text-right text-sm font-medium">
                                <a href="{{ route('seller.orders.show', $order) }}" class="text-green-600 hover:text-green-800">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
