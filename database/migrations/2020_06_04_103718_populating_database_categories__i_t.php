<?php

use Illuminate\Database\Migrations\Migration;

class PopulatingDatabaseCategoriesIT extends Migration
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
                ['name' => 'Komponente'],
                ['name' => 'Računala'],
                ['name' => 'Periferija']
            ]
        );

        DB::table('categories')->insert(
            [
                [
                    'group_id' => '7',
                    'name' => 'Memorija'
                ],
                [
                    'group_id' => '7',
                    'name' => 'RAM'
                ],
                [
                    'group_id' => '7',
                    'name' => 'Procesori'
                ],
                [
                    'group_id' => '7',
                    'name' => 'Grafičke kartice'
                ],
                [
                    'group_id' => '7',
                    'name' => 'Napajanja'
                ],
                [
                    'group_id' => '7',
                    'name' => 'Ostale komponente'
                ],
                [
                    'group_id' => '8',
                    'name' => 'Prijenosna računala'
                ],
                [
                    'group_id' => '8',
                    'name' => 'Stolna računala'
                ],
                [
                    'group_id' => '8',
                    'name' => 'Serveri'
                ],
                [
                    'group_id' => '8',
                    'name' => 'Ostala računala'
                ],
                [
                    'group_id' => '9',
                    'name' => 'Tipkovnice'
                ],
                [
                    'group_id' => '9',
                    'name' => 'Miševi'
                ],
                [
                    'group_id' => '9',
                    'name' => 'Monitori'
                ],
                [
                    'group_id' => '9',
                    'name' => 'Audio i video'
                ],
                [
                    'group_id' => '9',
                    'name' => 'Ostala periferija'
                ],
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
