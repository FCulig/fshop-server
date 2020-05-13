<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTranscationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transcations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->integer('item_id')->unsigned();
            $table->foreign('item_id')->references('id')->on('cart_items')->onDelete('cascade');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('address');
            $table->string('city');
            $table->string('country');
            $table->string('zip_code');
            $table->integer('status_id')->unsigned();
            $table->foreign('status_id')->references('id')->on('transaction_statuses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transcations');
    }
}
