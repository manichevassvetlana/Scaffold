<?php

use Illuminate\Database\Migrations\Migration;

class CreateNotificationsCollection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $seeder = new FillNotificationsCollection();
        $seeder->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $resources = new \App\Notifications();
        $resources->removeCollection();
    }
}
