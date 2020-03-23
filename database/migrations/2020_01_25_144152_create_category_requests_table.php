<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('group_id')->unsigned();
            $table->foreign('group_id')->references('id')->on('categories')->onDelete('cascade');
            $table->boolean('resolved')->default(false); 
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
        Schema::dropIfExists('category_requests');
    }
}
