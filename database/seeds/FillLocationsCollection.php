<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class FillLocationsCollection extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $resources = new \App\Locations();
        $address = \App\Addresses::first();
        $resources->insert([
            ['id' => 1, 'position' => new \Google\Cloud\Datastore\GeoPoint(30.549298, -95.353900), 'country_id' => $address->first()->id, 'name' => 'Home', 'description' => 'Test address.']
        ]);
    }
}
