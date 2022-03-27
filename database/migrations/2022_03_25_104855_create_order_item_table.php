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
        Schema::create('order_products', function (Blueprint $table) {
            $table->id();
            $table->string('article_code', 20);
            $table->string('article_name', 20);
            $table->decimal('unit_price');
            $table->integer('quantity');
            $table->unsignedBigInteger('order_id');
            $table->timestamps();
        });

        Schema::table('order_products', function (Blueprint $table) {
            $table->foreign('order_id')->references('id')->on('order');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_item');
    }
};
