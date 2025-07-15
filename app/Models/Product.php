<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\ActivityLog\Traits\LogsActivity;
use Spatie\ActivityLog\LogOptions;

class Product extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia, LogsActivity;

    protected $fillable = [
        'name',
        'slug',
        'sku',
        'barcode',
        'description',
        'category_id',
        'supplier_id',
        'purchase_price',
        'selling_price',
        'current_stock',
        'minimum_stock',
        'maximum_stock',
        'unit',
        'weight',
        'dimensions',
        'color',
        'size',
        'material',
        'brand',
        'status',
        'expiry_date',
        'manufacturing_date',
        'batch_number',
        'location',
        'tax_rate',
        'is_active',
        'notes',
    ];

    protected $casts = [
        'purchase_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'current_stock' => 'integer',
        'minimum_stock' => 'integer',
        'maximum_stock' => 'integer',
        'weight' => 'decimal:2',
        'tax_rate' => 'decimal:2',
        'expiry_date' => 'date',
        'manufacturing_date' => 'date',
        'is_active' => 'boolean',
        'dimensions' => 'array',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function stockTransactions(): HasMany
    {
        return $this->hasMany(StockTransaction::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp'])
            ->singleFile();

        $this->addMediaCollection('gallery')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(150)
            ->height(150)
            ->sharpen(10);

        $this->addMediaConversion('preview')
            ->width(500)
            ->height(500)
            ->nonQueued();
    }

    public function getImageUrlAttribute(): string
    {
        $media = $this->getFirstMedia('images');
        if ($media) {
            return $media->getUrl('preview');
        }

        return asset('images/placeholder-product.png');
    }

    public function getThumbnailUrlAttribute(): string
    {
        $media = $this->getFirstMedia('images');
        if ($media) {
            return $media->getUrl('thumb');
        }

        return asset('images/placeholder-product.png');
    }

    public function isLowStock(): bool
    {
        return $this->current_stock <= $this->minimum_stock;
    }

    public function isOutOfStock(): bool
    {
        return $this->current_stock <= 0;
    }

    public function isOverStock(): bool
    {
        return $this->maximum_stock && $this->current_stock >= $this->maximum_stock;
    }

    public function isExpired(): bool
    {
        return $this->expiry_date && $this->expiry_date->isPast();
    }

    public function isExpiringSoon(int $days = 30): bool
    {
        return $this->expiry_date && $this->expiry_date->diffInDays(now()) <= $days;
    }

    public function getProfitMarginAttribute(): float
    {
        if (!$this->purchase_price || $this->purchase_price == 0) {
            return 0;
        }

        return (($this->selling_price - $this->purchase_price) / $this->purchase_price) * 100;
    }

    public function getProfitAmountAttribute(): float
    {
        return $this->selling_price - $this->purchase_price;
    }

    public function getStockValueAttribute(): float
    {
        return $this->current_stock * $this->purchase_price;
    }

    public function getStockStatusAttribute(): string
    {
        if ($this->isOutOfStock()) {
            return 'out_of_stock';
        }

        if ($this->isLowStock()) {
            return 'low_stock';
        }

        if ($this->isOverStock()) {
            return 'over_stock';
        }

        return 'in_stock';
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->stock_status) {
            'out_of_stock' => 'red',
            'low_stock' => 'yellow',
            'over_stock' => 'orange',
            'in_stock' => 'green',
            default => 'gray',
        };
    }

    public function addStock(int $quantity, string $type = 'purchase', ?string $notes = null): void
    {
        $this->increment('current_stock', $quantity);

        $this->stockTransactions()->create([
            'type' => $type,
            'quantity' => $quantity,
            'remaining_stock' => $this->current_stock,
            'unit_price' => $this->purchase_price,
            'total_amount' => $quantity * $this->purchase_price,
            'notes' => $notes,
            'transaction_date' => now(),
        ]);
    }

    public function removeStock(int $quantity, string $type = 'sale', ?string $notes = null): void
    {
        $this->decrement('current_stock', $quantity);

        $this->stockTransactions()->create([
            'type' => $type,
            'quantity' => -$quantity,
            'remaining_stock' => $this->current_stock,
            'unit_price' => $this->selling_price,
            'total_amount' => $quantity * $this->selling_price,
            'notes' => $notes,
            'transaction_date' => now(),
        ]);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'sku', 'current_stock', 'selling_price', 'is_active'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
