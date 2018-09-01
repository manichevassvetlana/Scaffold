<?php

use Illuminate\Database\Migrations\Migration;

class CreateAbilitiesCollection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $seeder = new FillAbilitiesCollection();
        $seeder->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $resources = new \App\Abilities();
        $resources->removeCollection();
    }
}
