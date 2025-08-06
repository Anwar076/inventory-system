<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Category;

class CategoryUpdatedNotification extends Notification
{
    use Queueable;
    public $category;
    public function __construct(Category $category) { $this->category = $category; }
    public function via($notifiable) { return ['database']; }
    public function toDatabase($notifiable) {
        return [
            'category_id' => $this->category->id,
            'category_name' => $this->category->name,
            'message' => "De categorie '{$this->category->name}' is aangepast.",
            'url' => url('/categories/' . $this->category->id),
        ];
    }
}
