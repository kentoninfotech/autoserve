<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceordersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serviceorders', function (Blueprint $table) {
            $table->id();
            
            $table->string('customerid')->nullable();
            $table->string('jobno')->nullable();
            $table->string('servicename')->nullable();
            $table->string('description')->nullable();
            $table->string('mileage')->nullable();
            $table->string('amount')->nullable();
            $table->string('sdate')->nullable();
            $table->string('nextservicedate')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();

            $table->foreign('jobno')->references('jobno')->on('jobs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('serviceorders');
    }
}
