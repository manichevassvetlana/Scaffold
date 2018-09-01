<?php

use Illuminate\Database\Seeder;

class FillDocumentsCollection extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $resources = new \App\Documents();
        $resources->insert([
            ['category_id' => \App\Categories::paginate(1)->first()->id, 'reference_type' => 'App\APIs', 'reference_id' => \App\APIs::first()->id, 'title' => 'Test', 'author_id' => \App\Users::first()->id, 'version' => 1, 'body' => 'Test']
        ]);
    }
}
