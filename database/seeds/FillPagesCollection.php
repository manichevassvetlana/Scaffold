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
                'version_id' => 0,
                'versions' => [
                    0 => [
                        'name' => 'Test',
                        'type' => getLookupValue('PAGE_TYPE', 'about'),
                        'description' => 'Test',
                        'title' => 'Test',
                        'content' => 'Test',
                        'layout' => getLookupValue('PAGE_LAYOUT', 'app'),
                        'author' => \App\Users::first(),
                        'excerpt' => 'Test',
                        'meta_description' => 'test',
                        'meta_keywords' => 'test',
                        'image' => null,
                        'updated_by' => \App\Users::first(),
                        'updated_at' => \Carbon\Carbon::now()
                    ]
                ]
            ],
        ]);
    }
}
