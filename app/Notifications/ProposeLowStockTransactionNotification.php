<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Product;

class ProposeLowStockTransactionNotification extends Notification
{
    use Queueable;
    public $product;
    public $proposalId;
    public function __construct(Product $product, $proposalId)
    {
        $this->product = $product;
        $this->proposalId = $proposalId;
    }
    public function via($notifiable)
    {
        return ['database'];
    }
    public function toDatabase($notifiable)
    {
        return [
            'product_id' => $this->product->id,
            'product_name' => $this->product->name,
            'message' => "Product '{$this->product->name}' is onder minimumvoorraad. Wil je automatisch een voorraadtransactie aanmaken?",
            'proposal_id' => $this->proposalId,
            'approve_url' => url('/api/low-stock-proposals/' . $this->proposalId . '/approve'),
            'reject_url' => url('/api/low-stock-proposals/' . $this->proposalId . '/reject'),
        ];
    }
}
