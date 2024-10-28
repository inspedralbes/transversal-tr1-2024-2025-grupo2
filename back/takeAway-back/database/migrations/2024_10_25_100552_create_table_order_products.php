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
    Schema::create('order_products', function (Blueprint $table) {
        $table->id(); // bigint unsigned
        $table->foreignId('order_id')->constrained('orders')->onDelete('cascade'); // Asegúrate de que sea bigint unsigned
        $table->foreignId('product_id')->constrained()->onDelete('cascade'); // También debe ser bigint unsigned
        $table->unsignedInteger('quantity');
        $table->decimal('price', 8, 2);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_products');
    }
};
