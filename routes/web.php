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

    // Locaties (Pands) routes
    Route::get('/pands', function () {
        // You should fetch locaties from the database, here is a placeholder
        $locaties = \App\Models\Locatie::all();
        return inertia('Locaties/Index', [
            'locaties' => $locaties,
        ]);
    })->name('pands.index');

    Route::get('/pands/create', function () {
        return inertia('Locaties/Create');
    })->name('pands.create');

    Route::post('/pands', [\App\Http\Controllers\Dashboard\LocatieController::class, 'store'])->name('pands.store');

    Route::get('/pands/{id}', function ($id) {
        $locatie = \App\Models\Locatie::findOrFail($id);
        return inertia('Locaties/Show', [
            'locatie' => $locatie,
        ]);
    })->name('pands.show');

    Route::get('/pands/{id}/edit', function ($id) {
        $locatie = \App\Models\Locatie::findOrFail($id);
        return inertia('Locaties/Edit', [
            'locatie' => $locatie,
        ]);
    })->name('pands.edit');

    Route::put('/pands/{id}', [\App\Http\Controllers\Dashboard\LocatieController::class, 'update'])->name('pands.update');
    Route::delete('/pands/{id}', [\App\Http\Controllers\Dashboard\LocatieController::class, 'destroy'])->name('pands.destroy');
});

// Remove duplicate or conflicting routes for products, categories, suppliers, etc.
// The resource routes above already handle index/create/show/edit/store/update/destroy

// Debug route to test tenant finder
Route::get('/test-finder/{slug}', function ($slug) {
    $tenant = app(\App\Tenancy\FindTenantBySlug::class)->find($slug);
    dd($tenant);
});
