<?php

use Illuminate\Database\Migrations\Migration;

class CreatePagesCollection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $seeder = new FillPagesCollection();
        $seeder->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $resources = new \App\Pages();
        $resources->removeCollection();
    }
}
