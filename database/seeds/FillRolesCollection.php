<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class FillRolesCollection extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $resources = new \App\Roles();
        $resources->insert([
            ['name' => 'Admin', 'type' => getLookupValue('ROLE_TYPE', 'User')->id],
            ['name' => 'Developer', 'type' => getLookupValue('ROLE_TYPE', 'User')->id],
            ['name' => 'Analyst', 'type' => getLookupValue('ROLE_TYPE', 'User')->id],
            ['name' => 'Clerk', 'type' => getLookupValue('ROLE_TYPE', 'User')->id],
            ['name' => 'Organization Owner', 'type' => getLookupValue('ROLE_TYPE', 'Organization')->id],
            ['name' => 'Organization User', 'type' => getLookupValue('ROLE_TYPE', 'Organization')->id],
        ]);

        \App\Users::where('email', 'admin@admin.com')->first()->update(['roles' => [\App\Roles::where('name', 'Admin')->first()]]);
    }
}
