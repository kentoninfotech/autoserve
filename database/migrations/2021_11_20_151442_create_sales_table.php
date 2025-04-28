<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('setting_id')->nullable()->constrained('settings')->onDelete('cascade');
            $table->string('customerid')->nullable();
            $table->string('jobid')->nullable();
            $table->string('salesdesc')->nullable();
            $table->string('partno')->nullable();
            $table->string('quantity')->nullable();
            $table->float('amount',12,2)->default(0);
            $table->string('datesold')->nullable();
            $table->string('paymethod')->nullable();
            $table->string('particulars')->nullable();
            $table->foreign('jobid')->references('jobno')->on('jobs')->onDelete('cascade');
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
        Schema::dropIfExists('sales');
    }
}
