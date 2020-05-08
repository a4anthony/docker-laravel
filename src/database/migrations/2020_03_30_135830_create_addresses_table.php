<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'addresses',
            function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id');
                $table->integer('address_id');
                $table->string('first_name');
                $table->string('last_name');
                $table->char('phone');
                $table->string('address_address')->nullable();
                $table->string('address_number')->nullable();
                $table->double('address_latitude')->nullable();
                $table->double('address_longitude')->nullable();
                $table->string('address_additional')->nullable();
                $table->boolean('is_default')->nullable();
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
        Schema::dropIfExists('addresses');
    }
}
