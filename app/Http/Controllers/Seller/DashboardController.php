<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $seller = Auth::user();
        
        // Get seller's products statistics
        $totalProducts = $seller->products()->count();
        $activeProducts = $seller->products()->where('stock', '>', 0)->count();
        $outOfStock = $seller->products()->where('stock', 0)->count();
        $totalValue = $seller->products()->sum(\DB::raw('price * stock'));
        
        // Get recent products
        $recentProducts = $seller->products()->latest()->take(5)->get();
        
        return view('seller.dashboard', compact(
            'totalProducts',
            'activeProducts',
            'outOfStock',
            'totalValue',
            'recentProducts'
        ));
    }
}
