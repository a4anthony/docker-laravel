<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'products',
            function (Blueprint $table) {
                $table->Increments('id');
                $table->char('barcode');
                $table->string('title');
                $table->string('slug');
                $table->text('brief_description');
                $table->text('features');
                $table->text('specifications');
                $table->unsignedInteger('main_category_id');
                $table->foreign('main_category_id')
                    ->references('id')->on('categories')
                    ->onDelete('cascade');
                $table->unsignedInteger('sub_category_id');
                $table->foreign('sub_category_id')
                    ->references('id')->on('sub_categories')
                    ->onDelete('cascade');
                $table->boolean('live')->default(1);
                $table->string('brand');
                $table->integer('initial_price');
                $table->integer('discount');
                $table->integer('quantity');
                $table->integer('total_price');
                $table->string('returns');
                $table->string('delivery');
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
        Schema::dropIfExists('products');
    }
}
