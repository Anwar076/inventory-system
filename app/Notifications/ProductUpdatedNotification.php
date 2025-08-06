<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\Product;

class ProductUpdatedNotification extends Notification
{
    use Queueable;

    public $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Product aangepast')
            ->line("Het product '{$this->product->name}' is aangepast.")
            ->action('Bekijk product', url('/products/' . $this->product->id));
    }

    public function toDatabase($notifiable)
    {
        return [
            'product_id' => $this->product->id,
            'product_name' => $this->product->name,
            'message' => "Het product '{$this->product->name}' is aangepast.",
            'url' => url('/products/' . $this->product->id),
        ];
    }
}
