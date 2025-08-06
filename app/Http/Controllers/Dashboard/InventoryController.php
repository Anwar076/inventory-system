<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Pand;
use App\Models\ProductStock;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    public function index()
    {
        $locaties = Pand::where('is_active', true)
            ->withCount(['productStocks as total_products' => function($query) {
                $query->where('current_stock', '>', 0);
            }])
            ->withSum(['productStocks as total_stock_value' => function($query) {
                $query->where('current_stock', '>', 0);
            }], 'current_stock')
            ->orderBy('name')
            ->get();

        // Bereken globale statistieken
        $globalStats = [
            'total_locations' => $locaties->count(),
            'total_products' => $locaties->sum('total_products'),
            'total_stock' => $locaties->sum('total_stock_value'),
            'low_stock_count' => ProductStock::where('current_stock', '<=', DB::raw('minimum_stock'))
                ->where('current_stock', '>', 0)
                ->count(),
            'out_of_stock_count' => ProductStock::where('current_stock', 0)->count(),
        ];

        return Inertia::render('Inventory/Index', [
            'locaties' => $locaties,
            'globalStats' => $globalStats,
        ]);
    }

    public function show($pandId)
    {
        $pand = Pand::findOrFail($pandId);
        
        $productStocks = ProductStock::where('pand_id', $pand->id)
            ->with(['product.category', 'product.supplier'])
            ->orderBy('current_stock', 'desc')
            ->get();

        // Haal alle producten op voor de "toevoegen" modal
        $allProducts = Product::where('is_active', true)
            ->orderBy('name')
            ->get();

        // Bereken statistieken
        $stats = [
            'total_products' => $productStocks->count(),
            'total_stock' => $productStocks->sum('current_stock'),
            'low_stock_products' => $productStocks->filter(function($stock) {
                return $stock->current_stock > 0 && $stock->current_stock <= $stock->minimum_stock;
            })->count(),
            'out_of_stock' => $productStocks->where('current_stock', 0)->count(),
            'total_value' => $productStocks->sum(function($stock) {
                return $stock->current_stock * ($stock->product->purchase_price ?? 0);
            }),
        ];

        return Inertia::render('Inventory/Show', [
            'locatie' => $pand,
            'productStocks' => $productStocks,
            'allProducts' => $allProducts,
            'stats' => $stats,
        ]);
    }

    public function updateStock(Request $request, $productStockId)
    {
        $productStock = ProductStock::findOrFail($productStockId);
        
        $request->validate([
            'current_stock' => 'required|integer|min:0',
            'minimum_stock' => 'required|integer|min:0',
            'maximum_stock' => 'nullable|integer|min:0',
        ]);

        // Check of maximum_stock groter is dan minimum_stock als beide zijn ingevuld
        if ($request->maximum_stock && $request->maximum_stock <= $request->minimum_stock) {
            return back()->with('error', 'Maximum voorraad moet groter zijn dan minimum voorraad!');
        }

        try {
            $productStock->update($request->only(['current_stock', 'minimum_stock', 'maximum_stock']));
            return back()->with('success', 'Voorraad succesvol bijgewerkt!');
        } catch (\Exception $e) {
            \Log::error('Error updating stock record: ' . $e->getMessage());
            return back()->with('error', 'Er is een fout opgetreden bij het bijwerken van de voorraad.');
        }
    }

    public function createStock(Request $request, $pandId)
    {
        $pand = Pand::findOrFail($pandId);
        
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'current_stock' => 'required|integer|min:0',
            'minimum_stock' => 'required|integer|min:0',
            'maximum_stock' => 'nullable|integer|min:0',
        ]);

        // Check of er al een stock record bestaat
        $existingStock = ProductStock::where('product_id', $request->product_id)
            ->where('pand_id', $pand->id)
            ->first();

        if ($existingStock) {
            return back()->with('error', 'Dit product heeft al een voorraad record op deze locatie!');
        }

        // Check of maximum_stock groter is dan minimum_stock als beide zijn ingevuld
        if ($request->maximum_stock && $request->maximum_stock <= $request->minimum_stock) {
            return back()->with('error', 'Maximum voorraad moet groter zijn dan minimum voorraad!');
        }

        try {
            ProductStock::create([
                'product_id' => $request->product_id,
                'pand_id' => $pand->id,
                'current_stock' => $request->current_stock,
                'minimum_stock' => $request->minimum_stock,
                'maximum_stock' => $request->maximum_stock,
            ]);

            return back()->with('success', 'Voorraad record succesvol aangemaakt!');
        } catch (\Exception $e) {
            \Log::error('Error creating stock record: ' . $e->getMessage());
            return back()->with('error', 'Er is een fout opgetreden bij het aanmaken van de voorraad record.');
        }
    }
} 