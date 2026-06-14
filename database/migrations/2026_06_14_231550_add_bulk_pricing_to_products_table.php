<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('bulk_price', 12, 2)->nullable(); // Harga grosir per item
            $table->integer('min_bulk_quantity')->default(10); // Minimal beli untuk dapat harga grosir
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['bulk_price', 'min_bulk_quantity']);
        });
    }
};
