<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pand extends Model
{
    use HasFactory, SoftDeletes;

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

    public function productStocks()
    {
        return $this->hasMany(\App\Models\ProductStock::class);
    }

    // Eventueel: relatie naar voorraadtransacties
    // public function stockTransactions()
    // {
    //     return $this->hasMany(\App\Models\StockTransaction::class);
    // }
}
