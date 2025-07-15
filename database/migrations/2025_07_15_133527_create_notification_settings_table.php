<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notification_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('low_stock_threshold')->default(10);
            $table->integer('expiry_alert_days')->default(30);
            $table->boolean('email_notifications_enabled')->default(true);
            $table->boolean('sms_notifications_enabled')->default(false);
            $table->string('slack_webhook_url')->nullable();
            $table->json('notification_emails')->nullable();
            $table->enum('alert_frequency', ['immediate', 'hourly', 'daily', 'weekly'])->default('daily');
            $table->boolean('business_hours_only')->default(false);
            $table->boolean('weekend_alerts')->default(true);
            $table->json('settings')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_settings');
    }
};
