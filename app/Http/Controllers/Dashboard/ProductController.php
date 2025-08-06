<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Spatie\Activitylog\Models\Activity;
use App\Models\User;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'supplier'])->latest()->paginate(20);
        return Inertia::render('Products/Index', [
            'products' => $products,
        ]);
    }

    public function create()
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        return Inertia::render('Products/Create', [
            'categories' => $categories,
            'suppliers' => $suppliers,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:255|unique:products,sku',
            'category_id' => 'nullable|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'purchase_price' => 'nullable|numeric',
            'selling_price' => 'nullable|numeric',
            'current_stock' => 'nullable|integer',
            'minimum_stock' => 'nullable|integer',
            'status' => 'nullable|string',
        ]);
        // Zet lege strings om naar 0
        foreach(['purchase_price','selling_price','current_stock','minimum_stock'] as $field) {
            if(empty($data[$field])) $data[$field] = 0;
        }
        // Genereer unieke slug
        $slug = Str::slug($data['name']);
        $originalSlug = $slug;
        $i = 1;
        while (\App\Models\Product::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $i++;
        }
        $data['slug'] = $slug;
        $product = Product::create($data);
        // Notificatie sturen naar alle gebruikers
        foreach (User::all() as $user) {
            $user->notify(new \App\Notifications\ProductCreatedNotification($product));
        }
        return redirect()->route('products.index')->with('success', 'Product created!');
    }

    public function show(Product $product)
    {
        $product->load(['category', 'supplier']);
        $activity = Activity::where('subject_type', Product::class)
            ->where('subject_id', $product->id)
            ->with('causer')
            ->latest()
            ->take(50)
            ->get()
            ->map(function ($log) {
                return [
                    'id' => $log->id,
                    'created_at' => $log->created_at->format('Y-m-d H:i'),
                    'causer_name' => $log->causer ? ($log->causer->name ?? '-') : '-',
                    'description' => $log->description,
                    'properties' => $log->properties,
                ];
            });
        return Inertia::render('Products/Show', [
            'product' => $product,
            'activity' => $activity,
        ]);
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        return Inertia::render('Products/Edit', [
            'product' => $product,
            'categories' => $categories,
            'suppliers' => $suppliers,
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:255|unique:products,sku,' . $product->id,
            'category_id' => 'nullable|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'purchase_price' => 'nullable|numeric',
            'selling_price' => 'nullable|numeric',
            'current_stock' => 'nullable|integer',
            'minimum_stock' => 'nullable|integer',
            'status' => 'nullable|string',
        ]);
        foreach(['purchase_price','selling_price','current_stock','minimum_stock'] as $field) {
            if(empty($data[$field])) $data[$field] = 0;
        }
        // Genereer unieke slug bij naamswijziging
        if ($data['name'] !== $product->name) {
            $slug = Str::slug($data['name']);
            $originalSlug = $slug;
            $i = 1;
            while (\App\Models\Product::where('slug', $slug)->where('id', '!=', $product->id)->exists()) {
                $slug = $originalSlug . '-' . $i++;
            }
            $data['slug'] = $slug;
        }
        $product->update($data);
        // Notificatie sturen naar alle gebruikers
        foreach (User::all() as $user) {
            $user->notify(new \App\Notifications\ProductUpdatedNotification($product));
        }
        return redirect()->route('products.index')->with('success', 'Product updated!');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted!');
    }
}
