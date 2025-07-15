<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Inventory Management Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration settings for the SaaS Inventory Management System
    |
    */

    'demo_mode' => env('INVENTORY_DEMO_MODE', false),
    
    'trial_days' => env('INVENTORY_TRIAL_DAYS', 14),

    /*
    |--------------------------------------------------------------------------
    | Subscription Limits
    |--------------------------------------------------------------------------
    */
    'max_products_starter' => env('INVENTORY_MAX_PRODUCTS_STARTER', 500),
    'max_users_starter' => env('INVENTORY_MAX_USERS_STARTER', 5),

    /*
    |--------------------------------------------------------------------------
    | Company Registration
    |--------------------------------------------------------------------------
    */
    'company_registration_enabled' => env('COMPANY_REGISTRATION_ENABLED', true),
    'company_trial_enabled' => env('COMPANY_TRIAL_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Stock Alert Thresholds
    |--------------------------------------------------------------------------
    */
    'default_low_stock_threshold' => 10,
    'default_expiry_alert_days' => 30,

    /*
    |--------------------------------------------------------------------------
    | File Upload Limits
    |--------------------------------------------------------------------------
    */
    'max_image_size' => 5 * 1024 * 1024, // 5MB
    'allowed_image_types' => ['jpeg', 'jpg', 'png', 'webp'],
    'max_images_per_product' => 10,

    /*
    |--------------------------------------------------------------------------
    | Product Configuration
    |--------------------------------------------------------------------------
    */
    'default_currency' => 'EUR',
    'default_unit' => 'pcs',
    
    'units' => [
        'pcs' => 'Pieces',
        'kg' => 'Kilograms',
        'g' => 'Grams',
        'l' => 'Liters',
        'ml' => 'Milliliters',
        'm' => 'Meters',
        'cm' => 'Centimeters',
        'box' => 'Boxes',
        'pack' => 'Packs',
        'bottle' => 'Bottles',
        'can' => 'Cans',
        'bag' => 'Bags',
    ],

    'currencies' => [
        'EUR' => '€',
        'USD' => '$',
        'GBP' => '£',
        'JPY' => '¥',
        'CAD' => 'C$',
        'AUD' => 'A$',
        'CHF' => 'CHF',
        'CNY' => '¥',
        'INR' => '₹',
    ],

    /*
    |--------------------------------------------------------------------------
    | Notification Settings
    |--------------------------------------------------------------------------
    */
    'notifications' => [
        'slack_enabled' => env('SLACK_NOTIFICATIONS_ENABLED', false),
        'sms_enabled' => env('SMS_NOTIFICATIONS_ENABLED', false),
        'email_enabled' => env('EMAIL_NOTIFICATIONS_ENABLED', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | API Configuration
    |--------------------------------------------------------------------------
    */
    'api' => [
        'rate_limit' => 60, // requests per minute
        'version' => 'v1',
        'pagination_limit' => 50,
    ],

    /*
    |--------------------------------------------------------------------------
    | Security Settings
    |--------------------------------------------------------------------------
    */
    'security' => [
        'password_min_length' => 8,
        'require_2fa' => false,
        'session_timeout' => 120, // minutes
        'max_login_attempts' => 5,
    ],

    /*
    |--------------------------------------------------------------------------
    | Report Settings
    |--------------------------------------------------------------------------
    */
    'reports' => [
        'cache_duration' => 3600, // 1 hour in seconds
        'export_formats' => ['pdf', 'excel', 'csv'],
        'max_export_records' => 10000,
    ],

    /*
    |--------------------------------------------------------------------------
    | Dashboard Widgets
    |--------------------------------------------------------------------------
    */
    'dashboard' => [
        'recent_transactions_limit' => 10,
        'low_stock_products_limit' => 5,
        'expiring_products_limit' => 5,
        'cache_duration' => 300, // 5 minutes
    ],
];