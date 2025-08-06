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
        $products = Product::whereColumn('current_stock', '<', 'minimum_stock')->get();
        if ($products->isEmpty()) {
            $this->info('Geen producten onder minimumvoorraad.');
            return 0;
        }
        foreach ($products as $product) {
            $proposalId = (string) Str::uuid();
            foreach (User::all() as $user) {
                $user->notify(new \App\Notifications\ProposeLowStockTransactionNotification($product, $proposalId));
            }
            $this->info('Voorstel verstuurd voor product: ' . $product->name);
        }
        return 0;
    }
}
