<?php

use Illuminate\Database\Migrations\Migration;

class CreateCountiesCollection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $seeder = new FillCountiesCollection();
        $seeder->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $resources = new \App\Counties();
        $resources->removeCollection();
    }
}
