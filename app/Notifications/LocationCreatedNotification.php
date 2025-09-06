<?php

namespace App\Notifications;

use App\Models\Pand;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LocationCreatedNotification extends Notification
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
            'title' => 'Nieuwe locatie aangemaakt',
            'message' => "Locatie '{$this->location->name}' is aangemaakt.",
            'location_id' => $this->location->id,
            'location_name' => $this->location->name,
        ];
    }
}