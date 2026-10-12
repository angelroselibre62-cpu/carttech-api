<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function stats()
    {
        return [
            'total_products' => Product::count(),
            'total_users' => User::count(),
            'total_stock' => (int) Product::sum('stock'),
            'inventory_value' => (float) Product::selectRaw('SUM(price * stock) as v')->value('v'),
            'low_stock' => Product::where('stock', '<=', 5)->count(),
            'categories' => Product::select('category')
                ->selectRaw('COUNT(*) as count')
                ->groupBy('category')
                ->get(),
        ];
    }
}