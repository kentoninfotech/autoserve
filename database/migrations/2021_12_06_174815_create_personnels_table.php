<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonnelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personnels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('setting_id')->nullable()->constrained('settings')->onDelete('cascade');
            $table->string('surname')->nullable();
            $table->string('firstname')->nullable();
            $table->string('othernames')->nullable();
            $table->string('designation')->nullable();
            $table->string('phoneno')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('department')->nullable();
            $table->string('salary')->nullable();
            $table->string('highestcert')->nullable();
            $table->string('password')->nullable();
            $table->string('guarantor')->nullable();
            $table->string('staffid')->nullable();
            $table->string('cv')->nullable();
            $table->string('dob')->nullable();
            $table->string('stateoforigin')->nullable();
            $table->string('maritalstatus')->nullable();
            $table->string('empdate')->nullable();
            $table->string('picture')->nullable();
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
        Schema::dropIfExists('personnel');
    }
}
