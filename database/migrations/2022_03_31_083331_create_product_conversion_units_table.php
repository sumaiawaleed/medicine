<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductConversionUnitsTable extends Migration
{
    public function up()
    {
        Schema::create('product_conversion_units', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->integer('from_id');
            $table->integer('to_id');
            $table->integer('unit_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

        });
    }

    public function down()
    {
        Schema::dropIfExists('product_conversion_units');
    }
}
