<?php

use Illuminate\Database\Migrations\Migration;

class CreateCategoriesCollection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $seeder = new FillCategoriesCollection();
        $seeder->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $resources = new \App\Categories();
        $resources->removeCollection();
    }
}
