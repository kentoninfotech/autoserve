<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePsfusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('psfus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('setting_id')->nullable()->constrained('settings')->onDelete('cascade');
            $table->string('customerid')->nullable();
            $table->string('vregno')->nullable();
            $table->string('jobno')->nullable();
            $table->string('psfudate')->nullable();
            $table->string('discussion')->nullable();
            $table->string('outcome')->nullable();
            $table->string('status')->nullable();

            $table->string('satisfied',50)->nullable(); // String for Yes/No values
            $table->string('treatment',50)->nullable(); // String for Friendly/Neutral/Impersonal
            $table->string('waitedlong',50)->nullable(); // String for No/Maybe/Yes
            $table->string('explained',50)->nullable(); // String for Yes/Not Really/No
            $table->string('ready',50)->nullable(); // String for Yes/No
            $table->string('timescore',50)->nullable(); // String for On Time/Not On Time
            $table->string('impressed',50)->nullable(); // String for Yes/Partially/No
            $table->string('recommend',50)->nullable(); // String for Yes/No

            $table->foreign('customerid')->references('customerid')->on('contacts')->onDelete('cascade');
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
        Schema::dropIfExists('psfus');
    }
}
