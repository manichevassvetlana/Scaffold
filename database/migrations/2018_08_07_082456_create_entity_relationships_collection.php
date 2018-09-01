<?php

use Illuminate\Database\Migrations\Migration;

class CreateEntityRelationshipsCollection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $seeder = new FillEntityRelationshipsCollection();
        $seeder->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $resources = new \App\EntityRelationships();
        $resources->removeCollection();
    }
}
