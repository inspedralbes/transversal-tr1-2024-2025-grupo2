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
        Schema::create('tables_products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->decimal('price', 8, 2);
            $table->string('image');
            $table->unsignedBigInteger('categoryId');
            $table->foreign('categoryId')->references('id')->on('tables_categories')->onDelete('cascade');
            $table->unsignedBigInteger('sizeId');
            $table->foreign('sizeId')->references('id')->on('tables_sizes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tables_products');
    }
};
