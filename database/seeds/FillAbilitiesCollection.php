<?php

use Illuminate\Database\Seeder;

class FillAbilitiesCollection extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $resources = new \App\Abilities();
        $resources->insert([
            ['name' => 'Test', 'function' => 'Test']
        ]);
    }
}
