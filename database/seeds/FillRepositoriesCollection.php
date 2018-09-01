<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class FillRepositoriesCollection extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $resources = new \App\Repositories();
        $resources->insert([
            ['type' => getLookupValue('REPOSITORY_TYPE', 'TFS')->id, 'url' => '', 'name' => 'Test', 'contributors' => 5]
        ]);
    }
}
