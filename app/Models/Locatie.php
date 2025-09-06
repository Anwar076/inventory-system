<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Locatie extends Model
{
    // This is an alias for the Pand model
    // We'll use the same table and functionality
    protected $table = 'pands';
    
    protected $fillable = [
        'name',
        'code',
        'type',
        'address',
        'city',
        'postal_code',
        'country',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function productStocks()
    {
        return $this->hasMany(ProductStock::class, 'pand_id');
    }

    public function getFullAddressAttribute(): string
    {
        $address = collect([
            $this->address,
            $this->city,
            $this->postal_code,
            $this->country,
        ])->filter()->implode(', ');

        return $address;
    }
}