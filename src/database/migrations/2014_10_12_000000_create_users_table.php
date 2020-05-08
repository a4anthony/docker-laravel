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
        Schema::create(
            'users',
            function (Blueprint $table) {
                $table->Increments('id');
                $table->string('firstname');
                $table->string('lastname');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->char('phone');
                $table->boolean('is_admin')->nullable();
                $table->boolean('status')->nullable();
                $table->string('password');
                $table->rememberToken();
                $table->string('token');
                $table->timestamps();
            }
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
