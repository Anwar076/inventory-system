<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StockTransaction;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Notifications\ProductLowStockNotification;

class StockTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = StockTransaction::with(['product', 'user'])
            ->latest('transaction_date')
            ->paginate(20);
        return Inertia::render('StockTransactions/Index', [
            'transactions' => $transactions->through(function($tx) {
                return [
                    'id' => $tx->id,
                    'transaction_date' => $tx->transaction_date->format('Y-m-d'),
                    'product_name' => $tx->product->name ?? '-',
                    'type' => ucfirst($tx->type),
                    'quantity' => $tx->quantity,
                    'user_name' => $tx->user->name ?? '-',
                    'notes' => $tx->notes,
                ];
            }),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();
        return Inertia::render('StockTransactions/Create', [
            'products' => $products,
            'suppliers' => $suppliers,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|string',
            'quantity' => 'required|integer',
            'transaction_date' => 'required|date',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'notes' => 'nullable|string',
        ]);
        $product = Product::findOrFail($data['product_id']);
        // Pas voorraad aan
        if (in_array($data['type'], ['purchase', 'return', 'adjustment']) && $data['quantity'] > 0) {
            $product->increment('current_stock', $data['quantity']);
        } else {
            $product->decrement('current_stock', abs($data['quantity']));
        }
        $tx = StockTransaction::create([
            'product_id' => $data['product_id'],
            'supplier_id' => $data['supplier_id'] ?? null,
            'user_id' => Auth::id(),
            'type' => $data['type'],
            'quantity' => $data['quantity'],
            'remaining_stock' => $product->current_stock,
            'unit_price' => $product->purchase_price,
            'total_amount' => $data['quantity'] * $product->purchase_price,
            'transaction_date' => $data['transaction_date'],
            'notes' => $data['notes'] ?? null,
        ]);

        // Check if product is now low stock and send notification
        if ($product->current_stock <= $product->minimum_stock && $product->minimum_stock > 0) {
            $users = User::all();
            foreach ($users as $user) {
                $user->notify(new ProductLowStockNotification($product));
            }
        }

        return redirect()->route('stock-transactions.index')->with('success', 'Stock transaction added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
