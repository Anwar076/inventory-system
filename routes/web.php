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
use App\Http\Controllers\Dashboard\InventoryController;
use App\Http\Controllers\Dashboard\LocatieController;
use App\Http\Controllers\Auth\CompanyRegistrationController;

// Central (non-tenant) routes
Route::get('/', function () {
    return view('welcome');
});

require __DIR__.'/auth.php';

// Redirect default registration to company registration
Route::get('/register', [CompanyRegistrationController::class, 'create'])->name('register');
Route::post('/register', [CompanyRegistrationController::class, 'store']);

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

    // Inventory routes
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/inventory/{pand}', [InventoryController::class, 'show'])->name('inventory.show');
    Route::post('/inventory/{pand}/stock', [InventoryController::class, 'createStock'])->name('inventory.stock.create');
    Route::put('/inventory/stock/{productStock}', [InventoryController::class, 'updateStock'])->name('inventory.stock.update');

    // Locaties (Pands) routes
    Route::resource('pands', LocatieController::class);
});

// Remove duplicate or conflicting routes for products, categories, suppliers, etc.
// The resource routes above already handle index/create/show/edit/store/update/destroy

// Debug route to test tenant finder
Route::get('/test-finder/{slug}', function ($slug) {
    $tenant = app(\App\Tenancy\FindTenantBySlug::class)->find($slug);
    dd($tenant);
});
