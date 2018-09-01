<?php

use Illuminate\Database\Migrations\Migration;

class CreatePlansCollection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $seeder = new FillPlansCollection();
        $seeder->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $resources = new \App\Plans();
        $resources->removeCollection();
    }
}
