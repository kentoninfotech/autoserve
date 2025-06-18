<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('setting_id')->nullable()->constrained('settings')->onDelete('cascade');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('car_id');
            $table->decimal('price', 15, 2);
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('car_orders')->onDelete('cascade');
            $table->foreign('car_id')->references('id')->on('car_inventories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('car_order_items');
    }
}
