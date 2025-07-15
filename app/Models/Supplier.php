<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\ActivityLog\Traits\LogsActivity;
use Spatie\ActivityLog\LogOptions;

class Supplier extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'name',
        'company_name',
        'email',
        'phone',
        'mobile',
        'website',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'tax_number',
        'contact_person',
        'payment_terms',
        'credit_limit',
        'notes',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'credit_limit' => 'decimal:2',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function stockTransactions(): HasMany
    {
        return $this->hasMany(StockTransaction::class);
    }

    public function getFullAddressAttribute(): string
    {
        $address = collect([
            $this->address,
            $this->city,
            $this->state,
            $this->postal_code,
            $this->country,
        ])->filter()->implode(', ');

        return $address;
    }

    public function getProductsCountAttribute(): int
    {
        return $this->products()->count();
    }

    public function getTotalPurchaseAmountAttribute(): float
    {
        return $this->stockTransactions()
            ->where('type', 'purchase')
            ->sum('total_amount');
    }

    public function getAverageOrderValueAttribute(): float
    {
        $purchaseTransactions = $this->stockTransactions()
            ->where('type', 'purchase')
            ->get();

        if ($purchaseTransactions->isEmpty()) {
            return 0;
        }

        return $purchaseTransactions->sum('total_amount') / $purchaseTransactions->count();
    }

    public function getLastOrderDateAttribute(): ?\Carbon\Carbon
    {
        $lastTransaction = $this->stockTransactions()
            ->where('type', 'purchase')
            ->latest('transaction_date')
            ->first();

        return $lastTransaction?->transaction_date;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'email', 'phone', 'is_active'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
