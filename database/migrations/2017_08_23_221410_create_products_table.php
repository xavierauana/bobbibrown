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
    public function up() {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name");
            $table->text("keywords");
            $table->text("content");

            $table->integer('permission_id')->unsigned()->indexed();
            $table->timestamps();
        });

        Schema::create('line_product', function (Blueprint $table) {
            $table->integer('product_id')->unsigned();
            $table->integer('line_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('line_id')->references('id')->on('lines')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('line_product');
        Schema::dropIfExists('products');
    }
}
