<?php

use Illuminate\Database\Migrations\Migration;

class CreateCitiesCollection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $seeder = new FillCitiesCollection();
        $seeder->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $resources = new \App\Cities();
        $resources->removeCollection();
    }
}
