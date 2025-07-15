<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return inertia('Dashboard/Index', [
        'stats' => [
            'totalProducts' => 1247,
            'lowStockItems' => 23,
            'totalValue' => 156789,
            'monthlySales' => 89,
        ],
        'recentTransactions' => [
            ['id' => 1, 'product_name' => 'Wireless Headphones', 'type' => 'sale', 'quantity' => -2, 'amount' => '159.98', 'date' => '2025-01-15'],
            ['id' => 2, 'product_name' => 'Office Chair', 'type' => 'purchase', 'quantity' => 10, 'amount' => '1299.90', 'date' => '2025-01-15'],
            ['id' => 3, 'product_name' => 'Laptop Stand', 'type' => 'sale', 'quantity' => -1, 'amount' => '45.99', 'date' => '2025-01-14'],
            ['id' => 4, 'product_name' => 'Desk Lamp', 'type' => 'adjustment', 'quantity' => -1, 'amount' => '0.00', 'date' => '2025-01-14'],
            ['id' => 5, 'product_name' => 'Notebook Set', 'type' => 'purchase', 'quantity' => 50, 'amount' => '299.50', 'date' => '2025-01-13'],
        ],
        'lowStockProducts' => [
            ['id' => 1, 'name' => 'Wireless Mouse', 'sku' => 'WM-001', 'current_stock' => 3, 'minimum_stock' => 10, 'image' => '/images/products/mouse.jpg'],
            ['id' => 2, 'name' => 'USB Cable', 'sku' => 'UC-002', 'current_stock' => 5, 'minimum_stock' => 20, 'image' => '/images/products/cable.jpg'],
            ['id' => 3, 'name' => 'Phone Case', 'sku' => 'PC-003', 'current_stock' => 2, 'minimum_stock' => 15, 'image' => '/images/products/case.jpg'],
            ['id' => 4, 'name' => 'Screen Protector', 'sku' => 'SP-004', 'current_stock' => 1, 'minimum_stock' => 25, 'image' => '/images/products/protector.jpg'],
        ]
    ]);
})->name('dashboard');

// Product routes
Route::get('/products', function () {
    return inertia('Products/Index', [
        'products' => [
            ['id' => 1, 'name' => 'Wireless Headphones', 'sku' => 'WH-001', 'price' => '79.99', 'stock' => 45, 'status' => 'active'],
            ['id' => 2, 'name' => 'Office Chair', 'sku' => 'OC-002', 'price' => '129.99', 'stock' => 12, 'status' => 'active'],
            ['id' => 3, 'name' => 'Laptop Stand', 'sku' => 'LS-003', 'price' => '45.99', 'stock' => 8, 'status' => 'active'],
        ]
    ]);
})->name('products.index');

Route::get('/products/create', function () {
    return inertia('Products/Create');
})->name('products.create');

// Other routes
Route::get('/categories', function () {
    return response()->json(['message' => 'Categories page - coming soon!']);
})->name('categories.index');

Route::get('/suppliers', function () {
    return response()->json(['message' => 'Suppliers page - coming soon!']);
})->name('suppliers.index');

Route::get('/suppliers/create', function () {
    return response()->json(['message' => 'Add Supplier page - coming soon!']);
})->name('suppliers.create');

Route::get('/stock-transactions', function () {
    return response()->json(['message' => 'Stock Transactions page - coming soon!']);
})->name('stock-transactions.index');

Route::get('/stock-transactions/create', function () {
    return response()->json(['message' => 'Add Stock page - coming soon!']);
})->name('stock-transactions.create');

Route::get('/reports', function () {
    return response()->json(['message' => 'Reports page - coming soon!']);
})->name('reports.index');

// require __DIR__.'/auth.php';
