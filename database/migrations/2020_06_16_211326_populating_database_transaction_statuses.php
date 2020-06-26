<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PopulatingDatabaseTransactionStatuses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('transaction_statuses')->insert(
            [
                ['name' => 'Naručeno'],
                ['name' => 'empty'],
                ['name' => 'Poslano'],
                ['name' => 'Otkazano']
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
