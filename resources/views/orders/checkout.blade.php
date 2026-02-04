@extends('layouts.app')

@section('title', 'Checkout - ShopNow')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Checkout</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Checkout Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold mb-6">Shipping Information</h2>
                
                <form method="POST" action="{{ route('orders.store') }}">
                    @csrf
                    
                    <div class="space-y-4">
                        <div>
                            <label for="customer_name" class="block text-gray-700 font-medium mb-2">Full Name</label>
                            <input type="text" id="customer_name" name="customer_name" value="{{ old('customer_name', auth()->user()->name) }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            @error('customer_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="customer_email" class="block text-gray-700 font-medium mb-2">Email</label>
                            <input type="email" id="customer_email" name="customer_email" value="{{ old('customer_email', auth()->user()->email) }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            @error('customer_email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="customer_phone" class="block text-gray-700 font-medium mb-2">Phone Number</label>
                            <input type="tel" id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            @error('customer_phone')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="shipping_address" class="block text-gray-700 font-medium mb-2">Shipping Address</label>
                            <textarea id="shipping_address" name="shipping_address" rows="4" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">{{ old('shipping_address') }}</textarea>
                            @error('shipping_address')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="notes" class="block text-gray-700 font-medium mb-2">Order Notes (Optional)</label>
                            <textarea id="notes" name="notes" rows="3"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" 
                        class="mt-6 w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition font-semibold">
                        Place Order
                    </button>
                </form>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                <h2 class="text-xl font-bold mb-4">Order Summary</h2>
                
                <div class="space-y-3 mb-4">
                    @foreach($cartItems as $item)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">{{ $item->product->name }} x{{ $item->quantity }}</span>
                            <span class="font-semibold">${{ number_format($item->product->price * $item->quantity, 2) }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="border-t pt-4 space-y-2">
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

                <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                    <p class="text-sm text-gray-700">
                        <strong>Payment Method:</strong> Cash on Delivery
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
