<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiagnosisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diagnosis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('setting_id')->nullable()->constrained('settings')->onDelete('cascade');
            $table->string('customerid')->nullable();
            $table->string('jobno')->nullable();
            $table->string('diagnosis')->nullable();
            $table->string('problems')->nullable();
            $table->string('causes')->nullable();
            $table->string('request')->nullable();
            $table->string('deliverydate')->nullable();
            $table->string('status')->nullable();
            $table->string('instructions')->nullable();
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('diagnosis');
    }
}
