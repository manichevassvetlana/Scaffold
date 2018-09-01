<?php

use Illuminate\Database\Migrations\Migration;

class CreateDevelopersCollection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $seeder = new FillDevelopersCollection();
        $seeder->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $resources = new \App\Developers();
        $resources->removeCollection();
    }
}
