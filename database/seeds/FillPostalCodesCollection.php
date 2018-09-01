<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class FillPostalCodesCollection extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $resources = new \App\PostalCodes();
        $city = \App\Cities::first();
        $county = \App\Counties::first();
        $resources->insert([
            [ 'postal_code' => '75763', 'city_id' => $city->id, 'county_id' => $county->id, 'state_id' => $city->state_id, 'country_id' => $city->country_id,  'active' => false],
            [ 'postal_code' => '75779', 'city_id' => $city->id, 'county_id' => $county->id, 'state_id' => $city->state_id, 'country_id' => $city->country_id,  'active' => false],
            [ 'postal_code' => '75801', 'city_id' => $city->id, 'county_id' => $county->id, 'state_id' => $city->state_id, 'country_id' => $city->country_id,  'active' => false],
            [ 'postal_code' => '75802', 'city_id' => $city->id, 'county_id' => $county->id, 'state_id' => $city->state_id, 'country_id' => $city->country_id,  'active' => false],
            [ 'postal_code' => '75803', 'city_id' => $city->id, 'county_id' => $county->id, 'state_id' => $city->state_id, 'country_id' => $city->country_id,  'active' => false],
            [ 'postal_code' => '75832', 'city_id' => $city->id, 'county_id' => $county->id, 'state_id' => $city->state_id, 'country_id' => $city->country_id,  'active' => false],
            [ 'postal_code' => '75839', 'city_id' => $city->id, 'county_id' => $county->id, 'state_id' => $city->state_id, 'country_id' => $city->country_id,  'active' => false],
            [ 'postal_code' => '75853', 'city_id' => $city->id, 'county_id' => $county->id, 'state_id' => $city->state_id, 'country_id' => $city->country_id,  'active' => false],
            [ 'postal_code' => '75861', 'city_id' => $city->id, 'county_id' => $county->id, 'state_id' => $city->state_id, 'country_id' => $city->country_id,  'active' => false],
            [ 'postal_code' => '75880', 'city_id' => $city->id, 'county_id' => $county->id, 'state_id' => $city->state_id, 'country_id' => $city->country_id,  'active' => false],
            [ 'postal_code' => '75882', 'city_id' => $city->id, 'county_id' => $county->id, 'state_id' => $city->state_id, 'country_id' => $city->country_id,  'active' => false],
            [ 'postal_code' => '75884', 'city_id' => $city->id, 'county_id' => $county->id, 'state_id' => $city->state_id, 'country_id' => $city->country_id,  'active' => false],
            [ 'postal_code' => '75886', 'city_id' => $city->id, 'county_id' => $county->id, 'state_id' => $city->state_id, 'country_id' => $city->country_id,  'active' => false],
            [ 'postal_code' => '79714', 'city_id' => $city->id, 'county_id' => $county->id, 'state_id' => $city->state_id, 'country_id' => $city->country_id,  'active' => false],
            [ 'postal_code' => '75901', 'city_id' => $city->id, 'county_id' => $county->id, 'state_id' => $city->state_id, 'country_id' => $city->country_id,  'active' => false],
            [ 'postal_code' => '75902', 'city_id' => $city->id, 'county_id' => $county->id, 'state_id' => $city->state_id, 'country_id' => $city->country_id,  'active' => false],
            [ 'postal_code' => '75903', 'city_id' => $city->id, 'county_id' => $county->id, 'state_id' => $city->state_id, 'country_id' => $city->country_id,  'active' => false],
            [ 'postal_code' => '75904', 'city_id' => $city->id, 'county_id' => $county->id, 'state_id' => $city->state_id, 'country_id' => $city->country_id,  'active' => false],
            [ 'postal_code' => '75915', 'city_id' => $city->id, 'county_id' => $county->id, 'state_id' => $city->state_id, 'country_id' => $city->country_id,  'active' => false],
            [ 'postal_code' => '75941', 'city_id' => $city->id, 'county_id' => $county->id, 'state_id' => $city->state_id, 'country_id' => $city->country_id,  'active' => false],
            [ 'postal_code' => '75949', 'city_id' => $city->id, 'county_id' => $county->id, 'state_id' => $city->state_id, 'country_id' => $city->country_id,  'active' => false],
            [ 'postal_code' => '75969', 'city_id' => $city->id, 'county_id' => $county->id, 'state_id' => $city->state_id, 'country_id' => $city->country_id,  'active' => false],
            [ 'postal_code' => '75980', 'city_id' => $city->id, 'county_id' => $county->id, 'state_id' => $city->state_id, 'country_id' => $city->country_id,  'active' => false],
            [ 'postal_code' => '78358', 'city_id' => $city->id, 'county_id' => $county->id, 'state_id' => $city->state_id, 'country_id' => $city->country_id,  'active' => false],
            [ 'postal_code' => '78381', 'city_id' => $city->id, 'county_id' => $county->id, 'state_id' => $city->state_id, 'country_id' => $city->country_id,  'active' => false],
            [ 'postal_code' => '78382', 'city_id' => $city->id, 'county_id' => $county->id, 'state_id' => $city->state_id, 'country_id' => $city->country_id,  'active' => false],
            [ 'postal_code' => '76351', 'city_id' => $city->id, 'county_id' => $county->id, 'state_id' => $city->state_id, 'country_id' => $city->country_id,  'active' => false],
            [ 'postal_code' => '76366', 'city_id' => $city->id, 'county_id' => $county->id, 'state_id' => $city->state_id, 'country_id' => $city->country_id,  'active' => false],
            [ 'postal_code' => '76370', 'city_id' => $city->id, 'county_id' => $county->id, 'state_id' => $city->state_id, 'country_id' => $city->country_id,  'active' => false],
            [ 'postal_code' => '76379', 'city_id' => $city->id, 'county_id' => $county->id, 'state_id' => $city->state_id, 'country_id' => $city->country_id,  'active' => false],
            [ 'postal_code' => '76389', 'city_id' => $city->id, 'county_id' => $county->id, 'state_id' => $city->state_id, 'country_id' => $city->country_id,  'active' => false],
            [ 'postal_code' => '79019', 'city_id' => $city->id, 'county_id' => $county->id, 'state_id' => $city->state_id, 'country_id' => $city->country_id,  'active' => false],
            [ 'postal_code' => '79094', 'city_id' => $city->id, 'county_id' => $county->id, 'state_id' => $city->state_id, 'country_id' => $city->country_id,  'active' => false],
            [ 'postal_code' => '78008', 'city_id' => $city->id, 'county_id' => $county->id, 'state_id' => $city->state_id, 'country_id' => $city->country_id,  'active' => false],
            [ 'postal_code' => '78011', 'city_id' => $city->id, 'county_id' => $county->id, 'state_id' => $city->state_id, 'country_id' => $city->country_id,  'active' => false],
            [ 'postal_code' => '78012', 'city_id' => $city->id, 'county_id' => $county->id, 'state_id' => $city->state_id, 'country_id' => $city->country_id,  'active' => false],
            [ 'postal_code' => '78026', 'city_id' => $city->id, 'county_id' => $county->id, 'state_id' => $city->state_id, 'country_id' => $city->country_id,  'active' => false],
            [ 'postal_code' => '78050', 'city_id' => $city->id, 'county_id' => $county->id, 'state_id' => $city->state_id, 'country_id' => $city->country_id,  'active' => false],
            [ 'postal_code' => '78052', 'city_id' => $city->id, 'county_id' => $county->id, 'state_id' => $city->state_id, 'country_id' => $city->country_id,  'active' => false],
            [ 'postal_code' => '78053', 'city_id' => $city->id, 'county_id' => $county->id, 'state_id' => $city->state_id, 'country_id' => $city->country_id,  'active' => false],
            [ 'postal_code' => '78062', 'city_id' => $city->id, 'county_id' => $county->id, 'state_id' => $city->state_id, 'country_id' => $city->country_id,  'active' => false],
            [ 'postal_code' => '78064', 'city_id' => $city->id, 'county_id' => $county->id, 'state_id' => $city->state_id, 'country_id' => $city->country_id,  'active' => false],
            [ 'postal_code' => '78065', 'city_id' => $city->id, 'county_id' => $county->id, 'state_id' => $city->state_id, 'country_id' => $city->country_id,  'active' => false],
            [ 'postal_code' => '77418', 'city_id' => $city->id, 'county_id' => $county->id, 'state_id' => $city->state_id, 'country_id' => $city->country_id,  'active' => false],
            [ 'postal_code' => '77452', 'city_id' => $city->id, 'county_id' => $county->id, 'state_id' => $city->state_id, 'country_id' => $city->country_id,  'active' => false],
            [ 'postal_code' => '77473', 'city_id' => $city->id, 'county_id' => $county->id, 'state_id' => $city->state_id, 'country_id' => $city->country_id,  'active' => false],
            [ 'postal_code' => '77474', 'city_id' => $city->id, 'county_id' => $county->id, 'state_id' => $city->state_id, 'country_id' => $city->country_id,  'active' => false],
            [ 'postal_code' => '77485', 'city_id' => $city->id, 'county_id' => $county->id, 'state_id' => $city->state_id, 'country_id' => $city->country_id,  'active' => false],
            [ 'postal_code' => '78931', 'city_id' => $city->id, 'county_id' => $county->id, 'state_id' => $city->state_id, 'country_id' => $city->country_id,  'active' => false],
            [ 'postal_code' => '78933', 'city_id' => $city->id, 'county_id' => $county->id, 'state_id' => $city->state_id, 'country_id' => $city->country_id,  'active' => false],
            [ 'postal_code' => '78944', 'city_id' => $city->id, 'county_id' => $county->id, 'state_id' => $city->state_id, 'country_id' => $city->country_id,  'active' => false],
            [ 'postal_code' => '78950', 'city_id' => $city->id, 'county_id' => $county->id, 'state_id' => $city->state_id, 'country_id' => $city->country_id,  'active' => false],
            [ 'postal_code' => '79320', 'city_id' => $city->id, 'county_id' => $county->id, 'state_id' => $city->state_id, 'country_id' => $city->country_id,  'active' => false],
            [ 'postal_code' => '79324', 'city_id' => $city->id, 'county_id' => $county->id, 'state_id' => $city->state_id, 'country_id' => $city->country_id,  'active' => false],
            ]);
    }
}
