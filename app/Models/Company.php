<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Cashier\Billable;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;

class Company extends BaseTenant implements TenantWithDatabase
{
    use HasFactory, HasDatabase, HasDomains, Billable;

    protected $fillable = [
        'name',
        'slug',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'website',
        'logo',
        'currency',
        'timezone',
        'settings',
        'trial_ends_at',
        'subscription_plan',
        'is_active',
    ];

    protected $casts = [
        'settings' => 'array',
        'trial_ends_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function subscription(): HasOne
    {
        return $this->hasOne(CompanySubscription::class, 'tenant_id');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'tenant_id');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function isOnTrial(): bool
    {
        return $this->trial_ends_at && $this->trial_ends_at->isFuture();
    }

    public function hasActiveSubscription(): bool
    {
        return $this->subscription && $this->subscription->is_active;
    }

    public function canCreateProducts(): bool
    {
        if ($this->isOnTrial()) {
            return true;
        }

        if (!$this->hasActiveSubscription()) {
            return false;
        }

        $plan = $this->subscription_plan;
        if ($plan === 'starter') {
            return $this->products()->count() < config('inventory.max_products_starter', 500);
        }

        return true; // Pro and Enterprise have unlimited
    }

    public function canCreateUsers(): bool
    {
        if ($this->isOnTrial()) {
            return true;
        }

        if (!$this->hasActiveSubscription()) {
            return false;
        }

        $plan = $this->subscription_plan;
        if ($plan === 'starter') {
            return $this->users()->count() < config('inventory.max_users_starter', 5);
        }

        return true; // Pro and Enterprise have unlimited
    }

    // These will be available in tenant context
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function suppliers(): HasMany
    {
        return $this->hasMany(Supplier::class);
    }
}
