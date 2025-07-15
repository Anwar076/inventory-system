<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\ActivityLog\Traits\LogsActivity;
use Spatie\ActivityLog\LogOptions;

class StockTransaction extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'product_id',
        'supplier_id',
        'user_id',
        'type',
        'quantity',
        'remaining_stock',
        'unit_price',
        'total_amount',
        'transaction_date',
        'reference_number',
        'batch_number',
        'expiry_date',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'remaining_stock' => 'integer',
        'unit_price' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'transaction_date' => 'datetime',
        'expiry_date' => 'date',
    ];

    const TYPE_PURCHASE = 'purchase';
    const TYPE_SALE = 'sale';
    const TYPE_ADJUSTMENT = 'adjustment';
    const TYPE_RETURN = 'return';
    const TYPE_TRANSFER = 'transfer';
    const TYPE_WASTE = 'waste';
    const TYPE_LOSS = 'loss';

    public static function getTypes(): array
    {
        return [
            self::TYPE_PURCHASE => 'Purchase',
            self::TYPE_SALE => 'Sale',
            self::TYPE_ADJUSTMENT => 'Adjustment',
            self::TYPE_RETURN => 'Return',
            self::TYPE_TRANSFER => 'Transfer',
            self::TYPE_WASTE => 'Waste',
            self::TYPE_LOSS => 'Loss',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getTypeColorAttribute(): string
    {
        return match ($this->type) {
            self::TYPE_PURCHASE => 'green',
            self::TYPE_SALE => 'blue',
            self::TYPE_ADJUSTMENT => 'yellow',
            self::TYPE_RETURN => 'purple',
            self::TYPE_TRANSFER => 'indigo',
            self::TYPE_WASTE => 'orange',
            self::TYPE_LOSS => 'red',
            default => 'gray',
        };
    }

    public function getFormattedQuantityAttribute(): string
    {
        $prefix = $this->quantity >= 0 ? '+' : '';
        return $prefix . number_format($this->quantity);
    }

    public function getFormattedAmountAttribute(): string
    {
        return number_format($this->total_amount, 2);
    }

    public function isIncoming(): bool
    {
        return in_array($this->type, [
            self::TYPE_PURCHASE,
            self::TYPE_RETURN,
            self::TYPE_ADJUSTMENT,
        ]) && $this->quantity > 0;
    }

    public function isOutgoing(): bool
    {
        return in_array($this->type, [
            self::TYPE_SALE,
            self::TYPE_TRANSFER,
            self::TYPE_WASTE,
            self::TYPE_LOSS,
            self::TYPE_ADJUSTMENT,
        ]) && $this->quantity < 0;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['product_id', 'type', 'quantity', 'unit_price'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
