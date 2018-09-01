<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use \App\Countries;

class FillStatesCollection extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $resources = new \App\States();
        $id = Countries::where('name', 'United States')->first()->id;
        $resources->insert([
            [ 'name' => 'U.S. Armed Forces – Americas','abbreviation' => 'AA', 'country_id' => $id, 'active' => false],
            [ 'name' => 'Alaska','abbreviation' => 'AK', 'country_id' => $id, 'active' => false],
            [ 'name' => 'Alabama','abbreviation' => 'AL', 'country_id' => $id, 'active' => false],
            [ 'name' => 'U.S. Armed Forces – Pacific','abbreviation' => 'AP', 'country_id' => $id, 'active' => false],
            [ 'name' => 'Arkansas','abbreviation' => 'AR', 'country_id' => $id, 'active' => false],
            [ 'name' => 'Arizona','abbreviation' => 'AZ', 'country_id' => $id, 'active' => false],
            [ 'name' => 'California','abbreviation' => 'CA', 'country_id' => $id, 'active' => false],
            [ 'name' => 'Colorado','abbreviation' => 'CO', 'country_id' => $id, 'active' => false],
            [ 'name' => 'Connecticut','abbreviation' => 'CT', 'country_id' => $id, 'active' => false],
            [ 'name' => 'District of Columbia','abbreviation' => 'DC', 'country_id' => $id, 'active' => false],
            [ 'name' => 'Delaware','abbreviation' => 'DE', 'country_id' => $id, 'active' => false],
            [ 'name' => 'Florida','abbreviation' => 'FL', 'country_id' => $id, 'active' => false],
            [ 'name' => 'Federated States of Micronesia','abbreviation' => 'FM', 'country_id' => $id, 'active' => false],
            [ 'name' => 'Georgia','abbreviation' => 'GA', 'country_id' => $id, 'active' => false],
            [ 'name' => 'Guam','abbreviation' => 'GU', 'country_id' => $id, 'active' => false],
            [ 'name' => 'Hawaii','abbreviation' => 'HI', 'country_id' => $id, 'active' => false],
            [ 'name' => 'Iowa','abbreviation' => 'IA', 'country_id' => $id, 'active' => false],
            [ 'name' => 'Idaho','abbreviation' => 'ID', 'country_id' => $id, 'active' => false],
            [ 'name' => 'Illinois','abbreviation' => 'IL', 'country_id' => $id, 'active' => false],
            [ 'name' => 'Indiana','abbreviation' => 'IN', 'country_id' => $id, 'active' => false],
            [ 'name' => 'Kansas','abbreviation' => 'KS', 'country_id' => $id, 'active' => false],
            [ 'name' => 'Kentucky','abbreviation' => 'KY', 'country_id' => $id, 'active' => false],
            [ 'name' => 'Louisiana','abbreviation' => 'LA', 'country_id' => $id, 'active' => false],
            [ 'name' => 'Massachusetts','abbreviation' => 'MA', 'country_id' => $id, 'active' => false],
            [ 'name' => 'Maryland','abbreviation' => 'MD', 'country_id' => $id, 'active' => false],
            [ 'name' => 'Maine','abbreviation' => 'ME', 'country_id' => $id, 'active' => false],
            [ 'name' => 'Marshall Islands','abbreviation' => 'MH', 'country_id' => $id, 'active' => false],
            [ 'name' => 'Michigan','abbreviation' => 'MI', 'country_id' => $id, 'active' => false],
            [ 'name' => 'Minnesota','abbreviation' => 'MN', 'country_id' => $id, 'active' => false],
            [ 'name' => 'Missouri','abbreviation' => 'MO', 'country_id' => $id, 'active' => false],
            [ 'name' => 'Northern Mariana Islands','abbreviation' => 'MP', 'country_id' => $id, 'active' => false],
            [ 'name' => 'Mississippi','abbreviation' => 'MS', 'country_id' => $id, 'active' => false],
            [ 'name' => 'Montana','abbreviation' => 'MT', 'country_id' => $id, 'active' => false],
            [ 'name' => 'North Carolina','abbreviation' => 'NC', 'country_id' => $id, 'active' => false],
            [ 'name' => 'North Dakota','abbreviation' => 'ND', 'country_id' => $id, 'active' => false],
            [ 'name' => 'Nebraska','abbreviation' => 'NE', 'country_id' => $id, 'active' => false],
            [ 'name' => 'New Hampshire','abbreviation' => 'NH', 'country_id' => $id, 'active' => false],
            [ 'name' => 'New Jersey','abbreviation' => 'NJ', 'country_id' => $id, 'active' => false],
            [ 'name' => 'New Mexico','abbreviation' => 'NM', 'country_id' => $id, 'active' => false],
            [ 'name' => 'Nevada','abbreviation' => 'NV', 'country_id' => $id, 'active' => false],
            [ 'name' => 'New York','abbreviation' => 'NY', 'country_id' => $id, 'active' => false],
            [ 'name' => 'Ohio','abbreviation' => 'OH', 'country_id' => $id, 'active' => false],
            [ 'name' => 'Oklahoma','abbreviation' => 'OK', 'country_id' => $id, 'active' => false],
            [ 'name' => 'Oregon','abbreviation' => 'OR', 'country_id' => $id, 'active' => false],
            [ 'name' => 'Pennsylvania','abbreviation' => 'PA', 'country_id' => $id, 'active' => false],
            [ 'name' => 'Palau','abbreviation' => 'PW', 'country_id' => $id, 'active' => false],
            [ 'name' => 'Rhode Island','abbreviation' => 'RI', 'country_id' => $id, 'active' => false],
            [ 'name' => 'South Carolina','abbreviation' => 'SC', 'country_id' => $id, 'active' => false],
            [ 'name' => 'South Dakota','abbreviation' => 'SD', 'country_id' => $id, 'active' => false],
            [ 'name' => 'Tennessee','abbreviation' => 'TN', 'country_id' => $id, 'active' => false],
            [ 'name' => 'Texas','abbreviation' => 'TX', 'country_id' => $id, 'active' => true],
            [ 'name' => 'Utah','abbreviation' => 'UT', 'country_id' => $id, 'active' => false],
            [ 'name' => 'Virginia','abbreviation' => 'VA', 'country_id' => $id, 'active' => false],
            [ 'name' => 'Vermont','abbreviation' => 'VT', 'country_id' => $id, 'active' => false],
            [ 'name' => 'Washington','abbreviation' => 'WA', 'country_id' => $id, 'active' => false],
            [ 'name' => 'Wisconsin','abbreviation' => 'WI', 'country_id' => $id, 'active' => false],
            [ 'name' => 'West Virginia','abbreviation' => 'WV', 'country_id' => $id, 'active' => false],
            [ 'name' => 'Wyoming','abbreviation' => 'WY', 'country_id' => $id, 'active' => false],
            [ 'name' => 'U.S. Armed Forces – Europe','abbreviation' => 'AE', 'country_id' => $id, 'active' => false]
        ]);
    }
}
