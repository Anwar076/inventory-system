<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\SupplierController;
use App\Http\Controllers\Dashboard\StockTransactionController;
use App\Http\Controllers\Dashboard\ReportController;
use App\Http\Controllers\Dashboard\SettingsController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\BillingController;
use App\Http\Controllers\Auth\CompanyRegistrationController;

// Central (non-tenant) routes
Route::get('/', function () {
    return view('welcome');
});

require __DIR__.'/auth.php';

// Redirect default registration to company registration
Route::get('/register', [\App\Http\Controllers\Auth\CompanyRegistrationController::class, 'create'])->name('register');
Route::post('/register', [\App\Http\Controllers\Auth\CompanyRegistrationController::class, 'store']);

// Tenant routes (single domain, path-based)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('stock-transactions', StockTransactionController::class);
    Route::get('/reports', [ReportController::class, 'index'])->name('reports');
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::resource('users', UserController::class);
    Route::get('/billing', [BillingController::class, 'index'])->name('billing');
});

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

// Debug route to test tenant finder
Route::get('/test-finder/{slug}', function ($slug) {
    $tenant = app(App\Tenancy\FindTenantBySlug::class)->find($slug);
    dd($tenant);
});
