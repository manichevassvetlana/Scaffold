<?php

use Illuminate\Database\Migrations\Migration;

class CreateSdksCollection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $seeder = new FillSDKsCollection();
        $seeder->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $resources = new \App\Sdks();
        $resources->removeCollection();
    }
}
