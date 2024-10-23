<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {


    public function up()
    {
        Schema::create("products", function (Blueprint $table) {
            $table->double("id");
            $table->string("title");
            $table->string("description");
            $table->string("image");
            $table->string("price");
            $table->string("category_id");
            $table->string("size_id");
        });

    }

    public function down(): void
    {
        Schema::dropIfExists("products");
    }

};
