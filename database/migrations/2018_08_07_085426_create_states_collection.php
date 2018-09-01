<?php

use Illuminate\Database\Migrations\Migration;

class CreateStatesCollection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $seeder = new FillStatesCollection();
        $seeder->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $resources = new \App\States();
        $resources->removeCollection();
    }
}
