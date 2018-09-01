<?php

use Illuminate\Database\Seeder;

class FillAPIsCollection extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $resources = new \App\APIs();
        $resources->insert([
            ['type' => getLookupValue('API_TYPE', 'Public')->id, 'name' => 'Test', 'version' => 1, 'deprecated' => 1, 'deprecated_at' => null]
        ]);
    }
}
