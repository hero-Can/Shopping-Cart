<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->text("description"); // Changed to 'text' for potentially longer descriptions
            $table->decimal("price", 10, 2); // Using decimal for price (10 digits total, 2 after decimal)
            $table->string("image"); // Assuming it's a file path or URL (string should be fine)
            $table->integer("stock"); // Using integer for stock
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
