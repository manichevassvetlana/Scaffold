<?php

use Illuminate\Database\Migrations\Migration;

class CreateRolesCollection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $seeder = new FillRolesCollection();
        $seeder->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $resources = new \App\Roles();
        $resources->removeCollection();
    }
}
