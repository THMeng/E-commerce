<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_product', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->integer('quantity');
            $table->float('regular_price');
            $table->float('sale_price');
            $table->integer('attribute_size');
            $table->string('attribute_color');
            $table->integer('category');
            $table->string('thumbnail');
            $table->integer('viewer');
            $table->integer('author');
            $table->longText('description');
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
        Schema::dropIfExists('log_product');
    }
};
