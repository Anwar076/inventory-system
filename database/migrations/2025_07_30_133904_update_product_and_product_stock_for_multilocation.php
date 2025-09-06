<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Verwijder current_stock uit products
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'current_stock')) {
                // First drop the index that includes current_stock
                $table->dropIndex(['current_stock', 'minimum_stock']);
                // Then drop the column
                $table->dropColumn('current_stock');
            }
        });

        // Voeg unieke index toe aan product_stocks
        Schema::table('product_stocks', function (Blueprint $table) {
            $table->unique(['product_id', 'pand_id'], 'product_pand_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Voeg current_stock weer toe aan products
        Schema::table('products', function (Blueprint $table) {
            $table->integer('current_stock')->default(0);
            // Recreate the index
            $table->index(['current_stock', 'minimum_stock']);
        });

        // Verwijder unieke index uit product_stocks
        Schema::table('product_stocks', function (Blueprint $table) {
            $table->dropUnique('product_pand_unique');
        });
    }
};
