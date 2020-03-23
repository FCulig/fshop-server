<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ExpandedUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function($table) {
            $table->renameColumn('name', 'first_name');
            $table->string('last_name');
            $table->date('birth_date');
            $table->string('profile_img_url');
            $table->integer('role_id')->unsigned();
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function($table) {
            $table->dropColumn('last_name');
            $table->dropColumn('birth_date');
            $table->dropColumn('profile_img_url');
            $table->dropColumn('role_id');
        });
    }
}
