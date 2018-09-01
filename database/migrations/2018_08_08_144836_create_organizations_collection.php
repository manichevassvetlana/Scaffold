<?php

use Illuminate\Database\Migrations\Migration;

class CreateOrganizationsCollection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $seeder = new FillOrganizationsCollection();
        $seeder->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $resources = new \App\Organizations();
        $resources->removeCollection();
    }
}
