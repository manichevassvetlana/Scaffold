<?php

use Illuminate\Database\Migrations\Migration;

class CreateApisCollection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $seeder = new FillAPIsCollection();
        $seeder->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $resources = new \App\Apis();
        $resources->removeCollection();
    }
}
