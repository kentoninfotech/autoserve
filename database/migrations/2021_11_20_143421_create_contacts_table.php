<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('setting_id')->nullable()->constrained('settings')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('telephoneno')->nullable();
            $table->string('email')->nullable();
            $table->string('organization')->nullable();
            $table->string('address')->nullable();
            $table->string('customerid')->unique();
            $table->string('remarks')->nullable();
            $table->string('sundry')->nullable();
            $table->string('credit')->nullable();
            $table->string('vat')->nullable();

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
        Schema::dropIfExists('contacts');
    }
}
