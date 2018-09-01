<?php

use Illuminate\Database\Seeder;

class FillAddressesCollection extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $resources = new \App\Addresses();
        $postalCode = \App\PostalCodes::first();
        $resources->insert([
            ['line_1' => '3202 Bagnoli Rose Lane', 'line_2' => '', 'line_3' => '', 'postal_code_id' => $postalCode->id, 'city_id' => $postalCode->city_id, 'state_id' => $postalCode->state_id, 'country_id' => $postalCode->country_id, 'active' => true]
        ]);
    }
}
