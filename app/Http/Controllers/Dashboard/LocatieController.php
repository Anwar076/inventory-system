<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Pand;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;
use App\Models\User;

class LocatieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $locaties = Pand::withCount('productStocks')->latest()->get();
        return Inertia::render('Locaties/Index', [
            'locaties' => $locaties,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Locaties/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50|unique:pands,code',
            'type' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'is_active' => 'boolean',
        ]);

        $data['is_active'] = $data['is_active'] ?? true;
        
        $locatie = Pand::create($data);
        
        // Notificatie sturen naar alle gebruikers
        foreach (User::all() as $user) {
            $user->notify(new \App\Notifications\LocationCreatedNotification($locatie));
        }
        
        return redirect()->route('pands.index')->with('success', 'Locatie aangemaakt!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pand $pand)
    {
        $pand->load('productStocks.product');
        return Inertia::render('Locaties/Show', [
            'locatie' => $pand,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pand $pand)
    {
        return Inertia::render('Locaties/Edit', [
            'locatie' => $pand,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pand $pand)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50|unique:pands,code,' . $pand->id,
            'type' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'is_active' => 'boolean',
        ]);

        $pand->update($data);
        
        // Notificatie sturen naar alle gebruikers
        foreach (User::all() as $user) {
            $user->notify(new \App\Notifications\LocationUpdatedNotification($pand));
        }
        
        return redirect()->route('pands.index')->with('success', 'Locatie bijgewerkt!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pand $pand)
    {
        $pand->delete();
        return redirect()->route('pands.index')->with('success', 'Locatie verwijderd!');
    }
}