<?php

namespace App\Notifications;

use App\Models\Pand;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LocationUpdatedNotification extends Notification
{
    use Queueable;

    protected $location;

    public function __construct(Pand $location)
    {
        $this->location = $location;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Locatie bijgewerkt',
            'message' => "Locatie '{$this->location->name}' is bijgewerkt.",
            'location_id' => $this->location->id,
            'location_name' => $this->location->name,
        ];
    }
}