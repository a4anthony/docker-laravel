<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImageWebpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'image_webps',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedInteger('product_id');
                $table->foreign('product_id')
                    ->references('id')->on('products')
                    ->onDelete('cascade');
                $table->string('image_link');
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
        Schema::dropIfExists('image_webps');
    }
}
