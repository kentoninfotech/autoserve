<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('setting_id')->nullable()->constrained('settings')->onDelete('cascade');
            $table->string('customerid')->nullable();
            $table->string('jobno')->nullable();
            $table->string('vregno')->nullable();
            $table->string('regdate')->nullable();
            $table->string('modelname')->nullable();
            $table->string('modelno')->nullable();
            $table->string('frameno')->nullable();
            $table->string('vin')->nullable();
            $table->string('color')->nullable();
            $table->string('chasisno')->nullable();
            $table->string('vcondition')->nullable();
            $table->string('daterecieved')->nullable();

            $table->foreign('customerid')->references('customerid')->on('contacts')->onDelete('cascade');

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
        Schema::dropIfExists('vehicles');
    }
}
