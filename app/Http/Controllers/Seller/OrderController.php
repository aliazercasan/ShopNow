<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $seller = auth()->user();
        
        // Get orders that contain products from this seller
        $orders = Order::whereHas('orderItems.product', function ($query) use ($seller) {
            $query->where('seller_id', $seller->id);
        })
        ->with(['user', 'orderItems.product'])
        ->latest()
        ->paginate(15);
        
        return view('seller.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $seller = auth()->user();
        
        // Ensure the order contains products from this seller
        $hasSellerProducts = $order->orderItems()
            ->whereHas('product', function ($query) use ($seller) {
                $query->where('seller_id', $seller->id);
            })
            ->exists();
        
        if (!$hasSellerProducts) {
            abort(403, 'Unauthorized action.');
        }
        
        $order->load(['user', 'orderItems.product']);
        
        // Filter order items to show only this seller's products
        $sellerOrderItems = $order->orderItems->filter(function ($item) use ($seller) {
            return $item->product->seller_id === $seller->id;
        });
        
        return view('seller.orders.show', compact('order', 'sellerOrderItems'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $seller = auth()->user();
        
        // Ensure the order contains products from this seller
        $hasSellerProducts = $order->orderItems()
            ->whereHas('product', function ($query) use ($seller) {
                $query->where('seller_id', $seller->id);
            })
            ->exists();
        
        if (!$hasSellerProducts) {
            abort(403, 'Unauthorized action.');
        }
        
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);
        
        $order->update(['status' => $validated['status']]);
        
        return redirect()->route('seller.orders.show', $order)
            ->with('success', 'Order status updated successfully!');
    }
}
