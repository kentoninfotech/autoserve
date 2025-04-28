<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('setting_id')->nullable()->constrained('settings')->onDelete('cascade');
            $table->string('title');
            $table->double('amount',10,2)->default(0)->nullable();
            $table->bigInteger('account_head')->unsigned()->nullable();
            $table->foreign('account_head')->references('id')->on('accountheads')->onDelete('cascade');

            $table->dateTime('dated')->nullable();
            $table->string('reference_no',20)->nullable();
            $table->string('upload',50)->nullable();
            $table->string('detail',100)->nullable();
            $table->foreignId('from')->nullable()->constrained('users','id')->onDelete('cascade');
            $table->foreignId('to')->nullable()->constrained('users','id')->onDelete('cascade');
            $table->foreignId('approved_by')->nullable()->constrained('users','id')->onDelete('cascade');
            $table->foreignId('recorded_by')->nullable()->constrained('users','id')->onDelete('cascade');
            $table->string('payment_status',100)->nullable();
            $table->string('transaction_id',40)->nullable();
            $table->double('balance',10,2)->nullable();
            $table->double('vat',10,2)->default(0)->nullable();
            $table->double('discount',10,2)->default(0)->nullable();
            $table->string('payment_type',100)->nullable();
            $table->string('payment_particulars',40)->nullable();
            $table->string('beneficiary',40)->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
