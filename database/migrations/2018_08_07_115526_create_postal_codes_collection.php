<?php

use Illuminate\Database\Migrations\Migration;

class CreatePostalCodesCollection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $seeder = new FillPostalCodesCollection();
        $seeder->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $resources = new \App\PostalCodes();
        $resources->removeCollection();
    }
}
