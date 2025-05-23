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
            $table->string('company_email')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('address')->nullable();
            $table->string('motto')->nullable();
            $table->string('logo')->nullable()->default('logo.png');
            $table->string('background')->nullable()->default('login-bg.jpg');
            $table->string('header')->nullable();
            $table->string('primary_color')->nullable()->default('#0000FF');
            $table->string('secondary_color')->nullable()->default('#5e9a52');
            $table->string('sms_api_key')->nullable();
            $table->string('sms_api_secret')->nullable();
            $table->string('mode')->nullable();
            $table->string('deployment_type')->nullable();
            $table->timestamps();
            
        });

        DB::table('settings')->insert(
            array(
                'user_id' => 1,
                'company_name' => 'AutoServe',
                'motto' => 'Automobile Management System',
                'logo' => 'logo.png',
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
