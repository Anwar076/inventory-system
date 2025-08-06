<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $lowStockProducts = Product::whereColumn('current_stock', '<=', 'minimum_stock')->get();
        $totalValue = Product::sum(\DB::raw('current_stock * purchase_price'));
        $monthlySales = StockTransaction::where('type', 'sale')
            ->whereMonth('transaction_date', now()->month)
            ->sum('total_amount');
        $recentTransactions = StockTransaction::with('product')
            ->latest('transaction_date')
            ->take(10)
            ->get();

        return Inertia::render('Dashboard/Index', [
            'stats' => [
                'totalProducts' => $totalProducts,
                'lowStockItems' => $lowStockProducts->count(),
                'totalValue' => $totalValue,
                'monthlySales' => $monthlySales,
            ],
            'recentTransactions' => $recentTransactions->map(function($t) {
                return [
                    'id' => $t->id,
                    'product_name' => $t->product->name ?? '',
                    'type' => $t->type,
                    'date' => $t->transaction_date,
                    'quantity' => $t->quantity,
                    'amount' => $t->total_amount,
                ];
            }),
            'lowStockProducts' => $lowStockProducts->map(function($p) {
                return [
                    'id' => $p->id,
                    'name' => $p->name,
                    'sku' => $p->sku,
                    'current_stock' => $p->current_stock,
                    'minimum_stock' => $p->minimum_stock,
                ];
            }),
        ]);
    }
}
