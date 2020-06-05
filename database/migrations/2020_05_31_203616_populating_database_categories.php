<?php

use Illuminate\Database\Migrations\Migration;

class PopulatingDatabaseCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('categories')->insert(
            [
                [
                    'group_id' => '1',
                    'name' => 'Osobna vozila'
                ],
                [
                    'group_id' => '1',
                    'name' => 'Kamperi'
                ],
                [
                    'group_id' => '1',
                    'name' => 'Gospodarska vozila'
                ],
                [
                    'group_id' => '1',
                    'name' => 'Ostali automobili'
                ],
                [
                    'group_id' => '2',
                    'name' => 'Skuteri'
                ],
                [
                    'group_id' => '2',
                    'name' => 'Cross'
                ],
                [
                    'group_id' => '2',
                    'name' => 'Cestovni'
                ],
                [
                    'group_id' => '2',
                    'name' => 'Quad'
                ],
                [
                    'group_id' => '2',
                    'name' => 'Ostali motori'
                ],
                [
                    'group_id' => '3',
                    'name' => 'Voće'
                ],
                [
                    'group_id' => '3',
                    'name' => 'Povrće'
                ],
                [
                    'group_id' => '3',
                    'name' => 'Slastice'
                ],
                [
                    'group_id' => '3',
                    'name' => 'Zimnica'
                ],
                [
                    'group_id' => '3',
                    'name' => 'Meso i mesnati proizvodi'
                ],
                [
                    'group_id' => '3',
                    'name' => 'Ostala hrana'
                ],
                [
                    'group_id' => '4',
                    'name' => 'Vina'
                ],
                [
                    'group_id' => '4',
                    'name' => 'Sokovi'
                ],
                [
                    'group_id' => '4',
                    'name' => 'Kava'
                ],
                [
                    'group_id' => '4',
                    'name' => 'Ostala pića'
                ],
                [
                    'group_id' => '5',
                    'name' => 'Ulja'
                ],
                [
                    'group_id' => '5',
                    'name' => 'Masti'
                ],
                [
                    'group_id' => '5',
                    'name' => 'Žitarice'
                ],
                [
                    'group_id' => '5',
                    'name' => 'Ostali začini'
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
