<?php

use Illuminate\Database\Seeder;

class FillDevelopersCollection extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $resources = new \App\Developers();
        $resources->insert([
            ['user_id' => \App\Users::first()->id, 'use_description' => 'test', 'preferred_languages' => 'test', 'personal_use' => false, 'business_use' => true]
        ]);
    }
}
