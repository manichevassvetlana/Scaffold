<?php

use Illuminate\Database\Migrations\Migration;

class CreateLookupValuesCollection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $seeder = new FillLookupValuesCollection();
        $seeder->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $resources = new \App\LookupValues();
        $resources->removeCollection();
    }
}
