<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('setting_id')->nullable()->constrained('settings')->onDelete('cascade');
            $table->string('customerid')->nullable();
            $table->string('jobno')->nullable();
            $table->string('invoiceno')->nullable();
            $table->string('title')->nullable();
            $table->float('amount',12,2)->default(0);
            $table->float('amountpaid',12,2)->default(0);
            $table->string('dated')->nullable();
            $table->string('credit')->nullable();
            $table->string('paymethod')->nullable();
            $table->string('particulars')->nullable();

            $table->foreign('jobno')->references('jobno')->on('jobs')->onDelete('cascade');            
            $table->foreign('customerid')->references('customerid')->on('contacts')->onDelete('cascade');;            

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
        Schema::dropIfExists('payments');
    }
}
