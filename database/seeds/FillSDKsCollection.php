<?php

use Illuminate\Database\Seeder;

class FillSDKsCollection extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $resources = new \App\Sdks();
        $resources->insert([
            ['type' => getLookupValue('SDK_TYPE', 'php')->id, 'version' => 1, 'name' => 'Test']
        ]);
    }
}
