<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('setting_id')->nullable()->constrained('settings')->onDelete('cascade');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->foreign('customer_id')->references('id')->on('contacts')->onDelete('set null');
            $table->string('order_number')->unique();
            $table->string('status')->default('pending'); // pending, completed, cancelled
            $table->string('payment_status')->default('unpaid'); // unpaid, paid, partial
            // $table->string('payment_method')->nullable(); // e.g., cash, card, bank transfer
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->decimal('discount_percent', 5, 2)->default(0);
            $table->decimal('discount_value', 15, 2)->default(0);
            $table->decimal('vat_percent', 5, 2)->default(0);
            $table->decimal('vat_value', 15, 2)->default(0);
            $table->decimal('total', 15, 2)->default(0);
            // $table->date('order_date')->nullable();
            // $table->date('delivery_date')->nullable();
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
        Schema::dropIfExists('car_orders');
    }
}
