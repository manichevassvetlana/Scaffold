<?php

use Illuminate\Database\Migrations\Migration;

class CreateAnnouncementsCollection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $seeder = new FillAnnouncementsCollection();
        $seeder->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $resources = new \App\Announcements();
        $resources->removeCollection();
    }
}
