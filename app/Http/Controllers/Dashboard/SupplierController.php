<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use Inertia\Inertia;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::latest()->paginate(20);
        return Inertia::render('Suppliers/Index', [
            'suppliers' => $suppliers,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = \App\Models\Product::orderBy('name')->get();
        return Inertia::render('Suppliers/Create', [
            'products' => $products,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSupplierRequest $request)
    {
        $data = $request->validated();
        $data['is_active'] = $data['is_active'] ?? true;
        $supplier = Supplier::create($data);
        // Notificatie sturen naar alle gebruikers
        foreach (User::all() as $user) {
            $user->notify(new \App\Notifications\SupplierCreatedNotification($supplier));
        }
        // Koppel producten
        if ($request->has('product_ids')) {
            \App\Models\Product::whereIn('id', $request->product_ids)->update(['supplier_id' => $supplier->id]);
        }
        return redirect()->route('suppliers.index')->with('success', 'Supplier created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        $products = $supplier->products()->latest()->get();
        $activity = Activity::where('subject_type', Supplier::class)
            ->where('subject_id', $supplier->id)
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
        return Inertia::render('Suppliers/Show', [
            'supplier' => $supplier,
            'products' => $products,
            'activity' => $activity,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        $products = \App\Models\Product::orderBy('name')->get();
        $linkedProductIds = $supplier->products()->pluck('id')->toArray();
        return Inertia::render('Suppliers/Edit', [
            'supplier' => $supplier,
            'products' => $products,
            'linkedProductIds' => $linkedProductIds,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSupplierRequest $request, Supplier $supplier)
    {
        $data = $request->validated();
        $supplier->update($data);
        // Notificatie sturen naar alle gebruikers
        foreach (User::all() as $user) {
            $user->notify(new \App\Notifications\SupplierUpdatedNotification($supplier));
        }
        // Ontkoppel alle producten eerst
        \App\Models\Product::where('supplier_id', $supplier->id)->update(['supplier_id' => null]);
        // Koppel geselecteerde producten
        if ($request->has('product_ids')) {
            \App\Models\Product::whereIn('id', $request->product_ids)->update(['supplier_id' => $supplier->id]);
        }
        return redirect()->route('suppliers.index')->with('success', 'Supplier updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return redirect()->route('suppliers.index')->with('success', 'Supplier deleted!');
    }

    public function manageProducts(Supplier $supplier)
    {
        $products = \App\Models\Product::orderBy('name')->get();
        $linkedProductIds = $supplier->products()->pluck('id')->toArray();
        return Inertia::render('Suppliers/ManageProducts', [
            'supplier' => $supplier,
            'products' => $products,
            'linkedProductIds' => $linkedProductIds,
        ]);
    }

    public function updateProducts(Request $request, Supplier $supplier)
    {
        $request->validate([
            'product_ids' => 'array',
            'product_ids.*' => 'exists:products,id',
        ]);
        // Ontkoppel alle producten eerst
        \App\Models\Product::where('supplier_id', $supplier->id)->update(['supplier_id' => null]);
        // Koppel geselecteerde producten
        if (!empty($request->product_ids)) {
            \App\Models\Product::whereIn('id', $request->product_ids)->update(['supplier_id' => $supplier->id]);
        }
        return back()->with('success', 'Producten bijgewerkt voor deze leverancier.');
    }
}
