<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Pand;

class LocationUpdatedNotification extends Notification
{
    use Queueable;
    public $location;
    public function __construct(Pand $location) { $this->location = $location; }
    public function via($notifiable) { return ['database']; }
    public function toMail($notifiable) {
        return (new MailMessage)
            ->subject('Locatie aangepast')
            ->line("De locatie '{$this->location->name}' is aangepast.")
            ->action('Bekijk locatie', url('/pands/' . $this->location->id));
    }
    public function toDatabase($notifiable) {
        return [
            'location_id' => $this->location->id,
            'location_name' => $this->location->name,
            'message' => "De locatie '{$this->location->name}' is aangepast.",
            'url' => url('/pands/' . $this->location->id),
        ];
    }
}
