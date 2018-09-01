<?php

use Illuminate\Database\Migrations\Migration;

class CreateDocumentsCollection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $seeder = new FillDocumentsCollection();
        $seeder->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $resources = new \App\Documents();
        $resources->removeCollection();
    }
}
