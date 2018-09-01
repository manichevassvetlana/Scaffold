<?php
use Illuminate\Database\Migrations\Migration;

class CreateAdressesCollection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $seeder = new FillAddressesCollection();
        $seeder->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $resources = new \App\Addresses();
        $resources->removeCollection();
    }
}
