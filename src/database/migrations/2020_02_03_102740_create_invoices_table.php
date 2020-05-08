<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'invoices',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('user_id');
                $table->char('invoice_id');
                $table->string('first_name');
                $table->string('last_name');
                $table->string('email');
                $table->string('status');
                $table->integer('product_id');
                $table->integer('quantity');
                $table->integer('price');
                $table->char('phone');
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
        Schema::dropIfExists('invoices');
    }
}
