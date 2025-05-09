<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('company_name')->nullable();
            $table->string('motto')->nullable();
            $table->string('logo')->nullable()->default('logo-dark.png');
            $table->string('address')->nullable();
            $table->string('background')->nullable()->default('login-bg.jpg');
            $table->string('mode')->nullable();
            $table->string('deployment_type')->nullable();
            $table->timestamps();
            
        });

        DB::table('settings')->insert(
            array(
                'company_name' => 'AutoServe',
                'motto' => 'Automobile Management System',
                'logo' => 'logo-dark.png',
                'background' => 'login-bg.jpg',
                'mode' => 'Active',
                'address'=>'Peace Park, FCT Abuja',
            )
        );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
