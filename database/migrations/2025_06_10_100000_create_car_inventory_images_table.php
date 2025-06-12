<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('car_inventory_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('setting_id')->nullable()->constrained('settings')->onDelete('cascade');
            $table->unsignedBigInteger('car_inventory_id');
            $table->string('image');
            $table->boolean('is_thumbnail')->default(false);
            $table->timestamps();

            $table->foreign('car_inventory_id')->references('id')->on('car_inventories')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('car_inventory_images');
    }
};
