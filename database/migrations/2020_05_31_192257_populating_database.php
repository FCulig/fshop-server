<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PopulatingDatabase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('category_groups')->insert(
            [
                ['name' => 'Automobili'],
                ['name' => 'Motori'],
                ['name' => 'Hrana'],
                ['name' => 'Piće'],
                ['name' => 'Začini'],
                ['name' => 'Ostalo'],
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
