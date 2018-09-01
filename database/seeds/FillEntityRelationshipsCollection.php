<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class FillEntityRelationshipsCollection extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $resources = new \App\EntityRelationships();
        $resources->insert([
            1 => ['name' => 'API', 'model' => 'API', 'path' => 'App\APIs', 'starts_at' => Carbon::now(), 'ends_at' => null]
        ]);
    }
}
