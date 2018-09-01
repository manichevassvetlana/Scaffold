<?php

use Illuminate\Database\Migrations\Migration;

class CreateRepositoriesCollection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $seeder = new FillRepositoriesCollection();
        $seeder->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $resources = new \App\Repositories();
        $resources->removeCollection();
    }
}
