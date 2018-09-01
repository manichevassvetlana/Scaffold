<?php

use Illuminate\Database\Seeder;

class FillOrganizationsCollection extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $resources = new \App\Organizations();
        $resources->insert([
            ['type' => getLookupValue('ORG_TYPE', 'Business')->id, 'name' => 'Test org',  'domain' => 'test-org.com', 'status' => getLookupValue('ORG_STATUS', 'Active')->id]
        ]);
    }
}
