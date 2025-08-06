<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductStock extends Model
{
    protected $fillable = [
        'product_id',
        'pand_id',
        'current_stock',
        'minimum_stock',
        'maximum_stock',
    ];

    protected $casts = [
        'current_stock' => 'integer',
        'minimum_stock' => 'integer',
        'maximum_stock' => 'integer',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function pand(): BelongsTo
    {
        return $this->belongsTo(Pand::class);
    }

    public function getStockStatusAttribute(): string
    {
        if ($this->current_stock <= $this->minimum_stock) {
            return 'low';
        } elseif ($this->maximum_stock && $this->current_stock >= $this->maximum_stock) {
            return 'high';
        } else {
            return 'normal';
        }
    }

    public function getStockPercentageAttribute(): float
    {
        if (!$this->maximum_stock) {
            return 0;
        }
        
        return ($this->current_stock / $this->maximum_stock) * 100;
    }
}
