<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            
            $table->string('phone_number')->nullable();
            $table->string('email')->nullable();
            $table->string('state')->nullable();
            $table->string('facility')->nullable();
           
            $table->string('status')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('role')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert(
            array(
                'name' => 'AutoServe Admin',
                'email' => 'admin@kojoautos.com',
                'password' => '$2y$10$CjKcFVg7zWhsdqlqfQVKDeTHYy/j/kFlTSWnNLkMHZhK7q8yXfaXG',
                'role' => 'AutoServe',
                'status' => 'Active',
                'facility' => 'AutoServe',
                'state' => 'Central'
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
        Schema::dropIfExists('users');
    }
}
