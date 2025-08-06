<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StockTransaction;
use Inertia\Inertia;

class ReportController extends Controller
{
    public function index()
    {
        $transactions = StockTransaction::with('product')->get()->map(function($tx) {
            return [
                'product_name' => $tx->product->name ?? '-',
                'type' => ucfirst($tx->type),
                'quantity' => $tx->quantity,
                'total_amount' => $tx->total_amount,
                'transaction_date' => $tx->transaction_date->format('Y-m-d'),
            ];
        });
        return Inertia::render('StockTransactions/Report', [
            'transactions' => $transactions,
        ]);
    }
}
