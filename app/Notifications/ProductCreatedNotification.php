<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Product;

class ProductCreatedNotification extends Notification
{
    use Queueable;
    public $product;
    public function __construct(Product $product) { $this->product = $product; }
    public function via($notifiable) { return ['database']; }
    public function toDatabase($notifiable) {
        return [
            'product_id' => $this->product->id,
            'product_name' => $this->product->name,
            'message' => "Het product '{$this->product->name}' is aangemaakt.",
            'url' => url('/products/' . $this->product->id),
        ];
    }
}
