<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Inertia\Inertia;
use Illuminate\Support\Str;
use App\Models\User;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::withCount('products')->with('parent')->orderBy('sort_order')->get();
        return Inertia::render('Categories/Index', [
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $products = Product::orderBy('name')->get();
        return Inertia::render('Categories/Create', [
            'categories' => $categories,
            'products' => $products,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $data = $request->validated();
        // Genereer unieke slug
        $slug = Str::slug($data['name']);
        $originalSlug = $slug;
        $i = 1;
        while (Category::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $i++;
        }
        $data['slug'] = $slug;
        $category = Category::create($data);
        // Notificatie sturen naar alle gebruikers
        foreach (User::all() as $user) {
            $user->notify(new \App\Notifications\CategoryCreatedNotification($category));
        }
        // Koppel producten
        if ($request->has('product_ids')) {
            Product::whereIn('id', $request->product_ids)->update(['category_id' => $category->id]);
        }
        return redirect()->route('categories.index')->with('success', 'Categorie aangemaakt!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $category->load(['parent', 'children', 'products']);
        return Inertia::render('Categories/Show', [
            'category' => $category,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $categories = Category::where('id', '!=', $category->id)->orderBy('name')->get();
        $products = Product::orderBy('name')->get();
        $linkedProductIds = $category->products()->pluck('id')->toArray();
        return Inertia::render('Categories/Edit', [
            'category' => $category,
            'categories' => $categories,
            'products' => $products,
            'linkedProductIds' => $linkedProductIds,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $data = $request->validated();
        // Genereer unieke slug bij naamswijziging
        if ($data['name'] !== $category->name) {
            $slug = Str::slug($data['name']);
            $originalSlug = $slug;
            $i = 1;
            while (Category::where('slug', $slug)->where('id', '!=', $category->id)->exists()) {
                $slug = $originalSlug . '-' . $i++;
            }
            $data['slug'] = $slug;
        }
        $category->update($data);
        // Notificatie sturen naar alle gebruikers
        foreach (User::all() as $user) {
            $user->notify(new \App\Notifications\CategoryUpdatedNotification($category));
        }
        // Ontkoppel alle producten eerst
        Product::where('category_id', $category->id)->update(['category_id' => null]);
        // Koppel geselecteerde producten
        if ($request->has('product_ids')) {
            Product::whereIn('id', $request->product_ids)->update(['category_id' => $category->id]);
        }
        return redirect()->route('categories.index')->with('success', 'Categorie bijgewerkt!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Categorie verwijderd!');
    }
}
