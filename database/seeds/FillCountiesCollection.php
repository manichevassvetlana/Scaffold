<?php

use Illuminate\Database\Seeder;

class FillCountiesCollection extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $resources = new \App\Counties();
        $state = \App\States::first();
        $resources->insert([
            [ 'name' => 'Autauga County','incits' => '1001', 'state_id' =>$state->id, 'country_id' => $state->country_id, 'active' => false],
            [ 'name' => 'Baldwin County','incits' => '1003', 'state_id' =>$state->id, 'country_id' => $state->country_id, 'active' => false],
            [ 'name' => 'Barbour County','incits' => '1005', 'state_id' =>$state->id, 'country_id' => $state->country_id, 'active' => false],
            [ 'name' => 'Bibb County','incits' => '1007', 'state_id' =>$state->id, 'country_id' => $state->country_id, 'active' => false],
            [ 'name' => 'Blount County','incits' => '1009', 'state_id' =>$state->id, 'country_id' => $state->country_id, 'active' => false],
            [ 'name' => 'Bullock County','incits' => '1011', 'state_id' =>$state->id, 'country_id' => $state->country_id, 'active' => false],
            [ 'name' => 'Butler County','incits' => '1013', 'state_id' =>$state->id, 'country_id' => $state->country_id, 'active' => false],
            [ 'name' => 'Calhoun County','incits' => '1015', 'state_id' =>$state->id, 'country_id' => $state->country_id, 'active' => false],
            [ 'name' => 'Chambers County','incits' => '1017', 'state_id' =>$state->id, 'country_id' => $state->country_id, 'active' => false],
            [ 'name' => 'Cherokee County','incits' => '1019', 'state_id' =>$state->id, 'country_id' => $state->country_id, 'active' => false],
            [ 'name' => 'Chilton County','incits' => '1021', 'state_id' =>$state->id, 'country_id' => $state->country_id, 'active' => false],
            [ 'name' => 'Choctaw County','incits' => '1023', 'state_id' =>$state->id, 'country_id' => $state->country_id, 'active' => false],
            [ 'name' => 'Clarke County','incits' => '1025', 'state_id' =>$state->id, 'country_id' => $state->country_id, 'active' => false],
            [ 'name' => 'Clay County','incits' => '1027', 'state_id' =>$state->id, 'country_id' => $state->country_id, 'active' => false],
            [ 'name' => 'Cleburne County','incits' => '1029', 'state_id' =>$state->id, 'country_id' => $state->country_id, 'active' => false],
            [ 'name' => 'Coffee County','incits' => '1031', 'state_id' =>$state->id, 'country_id' => $state->country_id, 'active' => false],
            [ 'name' => 'Colbert County','incits' => '1033', 'state_id' =>$state->id, 'country_id' => $state->country_id, 'active' => false],
            [ 'name' => 'Conecuh County','incits' => '1035', 'state_id' =>$state->id, 'country_id' => $state->country_id, 'active' => false],
            [ 'name' => 'Coosa County','incits' => '1037', 'state_id' =>$state->id, 'country_id' => $state->country_id, 'active' => false],
            [ 'name' => 'Covington County','incits' => '1039', 'state_id' =>$state->id, 'country_id' => $state->country_id, 'active' => false],
            [ 'name' => 'Crenshaw County','incits' => '1041', 'state_id' =>$state->id, 'country_id' => $state->country_id, 'active' => false],
            ]);
    }
}
