<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Str;

class ProposeLowStockTransaction extends Command
{
    protected $signature = 'inventory:propose-low-stock';
    protected $description = 'Stuur een voorstel voor voorraadtransactie bij lage voorraad, met goedkeur/afkeur link.';

    public function handle()
    {
        // Check products with low stock in main products table
        $lowStockProducts = Product::whereColumn('current_stock', '<=', 'minimum_stock')
                                 ->where('minimum_stock', '>', 0)
                                 ->get();

        if ($lowStockProducts->isEmpty()) {
            $this->info('Geen producten onder minimumvoorraad.');
            return 0;
        }

        // Send notifications
        $users = User::all();
        foreach ($lowStockProducts as $product) {
            // Send low stock notification
            foreach ($users as $user) {
                $user->notify(new \App\Notifications\ProductLowStockNotification($product));
            }

            // Send transaction proposal
            $proposalId = (string) Str::uuid();
            foreach ($users as $user) {
                $user->notify(new \App\Notifications\ProposeLowStockTransactionNotification($product, $proposalId));
            }
            
            $this->info('Notificaties verstuurd voor product: ' . $product->name);
        }
        
        return 0;
    }
}
