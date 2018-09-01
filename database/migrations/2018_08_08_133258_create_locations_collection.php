<?php

use Illuminate\Database\Migrations\Migration;

class CreateLocationsCollection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $seeder = new FillLocationsCollection();
        $seeder->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $resources = new \App\Locations();
        $resources->removeCollection();
    }
}
