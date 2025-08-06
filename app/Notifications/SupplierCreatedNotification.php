<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Supplier;

class SupplierCreatedNotification extends Notification
{
    use Queueable;
    public $supplier;
    public function __construct(Supplier $supplier) { $this->supplier = $supplier; }
    public function via($notifiable) { return ['database']; }
    public function toDatabase($notifiable) {
        return [
            'supplier_id' => $this->supplier->id,
            'supplier_name' => $this->supplier->name,
            'message' => "De leverancier '{$this->supplier->name}' is aangemaakt.",
            'url' => url('/suppliers/' . $this->supplier->id),
        ];
    }
}
