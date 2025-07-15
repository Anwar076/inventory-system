<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'low_stock_threshold',
        'expiry_alert_days',
        'email_notifications_enabled',
        'sms_notifications_enabled',
        'slack_webhook_url',
        'notification_emails',
        'alert_frequency',
        'business_hours_only',
        'weekend_alerts',
        'settings',
    ];

    protected $casts = [
        'email_notifications_enabled' => 'boolean',
        'sms_notifications_enabled' => 'boolean',
        'business_hours_only' => 'boolean',
        'weekend_alerts' => 'boolean',
        'low_stock_threshold' => 'integer',
        'expiry_alert_days' => 'integer',
        'notification_emails' => 'array',
        'settings' => 'array',
    ];

    const FREQUENCY_IMMEDIATE = 'immediate';
    const FREQUENCY_HOURLY = 'hourly';
    const FREQUENCY_DAILY = 'daily';
    const FREQUENCY_WEEKLY = 'weekly';

    public static function getFrequencies(): array
    {
        return [
            self::FREQUENCY_IMMEDIATE => 'Immediate',
            self::FREQUENCY_HOURLY => 'Hourly',
            self::FREQUENCY_DAILY => 'Daily',
            self::FREQUENCY_WEEKLY => 'Weekly',
        ];
    }

    public function shouldSendNotification(): bool
    {
        if (!$this->email_notifications_enabled && !$this->sms_notifications_enabled) {
            return false;
        }

        if ($this->business_hours_only && !$this->isBusinessHours()) {
            return false;
        }

        if (!$this->weekend_alerts && $this->isWeekend()) {
            return false;
        }

        return true;
    }

    public function isBusinessHours(): bool
    {
        $hour = now()->hour;
        return $hour >= 9 && $hour <= 17; // 9 AM to 5 PM
    }

    public function isWeekend(): bool
    {
        return now()->isWeekend();
    }

    public function getNotificationEmails(): array
    {
        return $this->notification_emails ?? [];
    }
}
