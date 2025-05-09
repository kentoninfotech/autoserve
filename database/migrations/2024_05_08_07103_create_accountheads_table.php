<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountheadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accountheads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('setting_id')->nullable()->constrained('settings')->onDelete('cascade');
            $table->string('title',50)->nullable();
            $table->string('category',50)->nullable();
            $table->string('type',50)->nullable();
            $table->string('description',50)->nullable();
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
        Schema::dropIfExists('accountheads');
    }
}
