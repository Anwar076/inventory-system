<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanySubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'plan',
        'stripe_subscription_id',
        'stripe_customer_id',
        'stripe_price_id',
        'status',
        'current_period_start',
        'current_period_end',
        'cancel_at_period_end',
        'cancelled_at',
        'trial_ends_at',
        'monthly_price',
        'yearly_price',
        'features',
        'limits',
    ];

    protected $casts = [
        'current_period_start' => 'datetime',
        'current_period_end' => 'datetime',
        'cancelled_at' => 'datetime',
        'trial_ends_at' => 'datetime',
        'cancel_at_period_end' => 'boolean',
        'monthly_price' => 'decimal:2',
        'yearly_price' => 'decimal:2',
        'features' => 'array',
        'limits' => 'array',
    ];

    const PLAN_STARTER = 'starter';
    const PLAN_PRO = 'pro';
    const PLAN_ENTERPRISE = 'enterprise';

    const STATUS_ACTIVE = 'active';
    const STATUS_CANCELED = 'canceled';
    const STATUS_INCOMPLETE = 'incomplete';
    const STATUS_INCOMPLETE_EXPIRED = 'incomplete_expired';
    const STATUS_PAST_DUE = 'past_due';
    const STATUS_TRIALING = 'trialing';
    const STATUS_UNPAID = 'unpaid';

    public static function getPlans(): array
    {
        return [
            self::PLAN_STARTER => [
                'name' => 'Starter',
                'description' => 'Perfect for small businesses',
                'monthly_price' => 19,
                'yearly_price' => 190,
                'features' => [
                    'Up to 500 products',
                    'Up to 5 users',
                    'Basic reporting',
                    'Email support',
                    'Mobile app access',
                ],
                'limits' => [
                    'max_products' => 500,
                    'max_users' => 5,
                    'storage_gb' => 1,
                ],
            ],
            self::PLAN_PRO => [
                'name' => 'Pro',
                'description' => 'For growing businesses',
                'monthly_price' => 49,
                'yearly_price' => 490,
                'features' => [
                    'Unlimited products',
                    'Unlimited users',
                    'Advanced reporting',
                    'Priority support',
                    'Mobile app access',
                    'API access',
                    'Integrations',
                ],
                'limits' => [
                    'max_products' => null,
                    'max_users' => null,
                    'storage_gb' => 10,
                ],
            ],
            self::PLAN_ENTERPRISE => [
                'name' => 'Enterprise',
                'description' => 'For large organizations',
                'monthly_price' => null, // Custom pricing
                'yearly_price' => null,
                'features' => [
                    'Everything in Pro',
                    'Custom integrations',
                    'Dedicated support',
                    'Advanced security',
                    'Custom reporting',
                    'Training sessions',
                ],
                'limits' => [
                    'max_products' => null,
                    'max_users' => null,
                    'storage_gb' => null,
                ],
            ],
        ];
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'tenant_id');
    }

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function isOnTrial(): bool
    {
        return $this->status === self::STATUS_TRIALING || 
               ($this->trial_ends_at && $this->trial_ends_at->isFuture());
    }

    public function isCanceled(): bool
    {
        return $this->status === self::STATUS_CANCELED;
    }

    public function isPastDue(): bool
    {
        return $this->status === self::STATUS_PAST_DUE;
    }

    public function daysUntilRenewal(): int
    {
        if (!$this->current_period_end) {
            return 0;
        }

        return $this->current_period_end->diffInDays(now());
    }

    public function getPlanDetails(): array
    {
        return self::getPlans()[$this->plan] ?? [];
    }

    public function canCreateProducts(int $count = 1): bool
    {
        $limits = $this->limits ?? $this->getPlanDetails()['limits'] ?? [];
        $maxProducts = $limits['max_products'] ?? null;

        if ($maxProducts === null) {
            return true; // Unlimited
        }

        $currentCount = $this->company->products()->count();
        return ($currentCount + $count) <= $maxProducts;
    }

    public function canCreateUsers(int $count = 1): bool
    {
        $limits = $this->limits ?? $this->getPlanDetails()['limits'] ?? [];
        $maxUsers = $limits['max_users'] ?? null;

        if ($maxUsers === null) {
            return true; // Unlimited
        }

        $currentCount = $this->company->users()->count();
        return ($currentCount + $count) <= $maxUsers;
    }

    public function getUsagePercentage(string $type): float
    {
        $limits = $this->limits ?? $this->getPlanDetails()['limits'] ?? [];
        
        switch ($type) {
            case 'products':
                $max = $limits['max_products'] ?? null;
                if ($max === null) return 0;
                $current = $this->company->products()->count();
                break;
            case 'users':
                $max = $limits['max_users'] ?? null;
                if ($max === null) return 0;
                $current = $this->company->users()->count();
                break;
            default:
                return 0;
        }

        return $max > 0 ? ($current / $max) * 100 : 0;
    }
}
