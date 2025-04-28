<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('setting_id')->nullable()->constrained('settings')->onDelete('cascade');
            $table->string('customerid',50)->nullable();
            $table->unsignedBigInteger('job_no')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->string('driver_name',50)->nullable();
            $table->string('driver_phone',50)->nullable();
            $table->string('delivery_company',100)->nullable();
            $table->date('expected_delivery_date')->nullable();
            $table->date('actual_delivery_date')->nullable();
            $table->text('other_instructions')->nullable();
            $table->string('payment_made',10)->nullable();
            $table->string('status',50)->nullable();
            $table->string('received_by',100)->nullable();
            $table->timestamps();
            $table->foreign('job_no')->references('id')->on('jobs')->onDelete('cascade');
            // Assuming you have a customers table
            $table->foreign('customerid')->references('customerid')->on('contacts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deliveries');
    }
}
