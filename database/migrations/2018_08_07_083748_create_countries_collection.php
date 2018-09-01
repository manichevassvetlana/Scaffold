<?php

use Illuminate\Database\Migrations\Migration;

class CreateCountriesCollection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $seeder = new FillCountriesCollection();
        $seeder->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $resources = new \App\Countries();
        $resources->removeCollection();
    }
}
