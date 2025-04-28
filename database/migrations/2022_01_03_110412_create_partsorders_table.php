<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartsordersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partsorders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('setting_id')->nullable()->constrained('settings')->onDelete('cascade');
            $table->string('customerid',30)->nullable();
            $table->string('jobno',30)->nullable();
            $table->string('partsname',60)->nullable();
            $table->string('partsno',40)->nullable();
            $table->string('quantity',30)->nullable();
            $table->float('amount',12,2)->default(0);
            $table->string('pdate')->nullable();
            $table->string('pid',30)->nullable();
            $table->string('status',30)->nullable();
            $table->foreign('jobno')->references('jobno')->on('jobs')->onDelete('cascade');
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
        Schema::dropIfExists('partsorders');
    }
}
