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
        Schema::create('car_inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('setting_id')->nullable()->constrained('settings')->onDelete('cascade');
            $table->string('make');
            $table->string('model');
            $table->string('year');
            $table->string('condition')->nullable();
            $table->string('mileage')->nullable();
            $table->string('fuel_type')->nullable();
            $table->string('transmission')->nullable();
            $table->string('vin')->nullable();
            $table->string('color')->nullable();
            $table->decimal('price', 15, 2)->nullable();
            $table->text('description')->nullable();
            $table->string('status')->default('available'); // available, sold
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
        Schema::dropIfExists('car_inventories');
    }
};
