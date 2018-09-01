<?php

use Illuminate\Database\Seeder;

class FillPagesCollection extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $resources = new \App\Pages();
        $resources->insert([
            ['slug' => 'testing1',
                'status' => getLookupValue('PAGE_STATUS', 'Draft')->id,
                'created_by' => \App\Users::first()->id,
                'version_id' => 1],
            ['slug' => 'testing2',
                'status' => getLookupValue('PAGE_STATUS', 'Published')->id,
                'created_by' => \App\Users::first()->id,
                'version_id' => 1],
            [
                'slug' => 'testing3',
                'status' => getLookupValue('PAGE_STATUS', 'Draft')->id,
                'created_by' => \App\Users::first()->id,
                'version_id' => 2],
            ['slug' => 'testing4',
                'status' => getLookupValue('PAGE_STATUS', 'Published')->id,
                'created_by' => \App\Users::first()->id,
                'version_id' => 2],
        ]);
    }
}
