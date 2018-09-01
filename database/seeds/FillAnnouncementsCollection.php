<?php

use Illuminate\Database\Seeder;

class FillAnnouncementsCollection extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $resources = new \App\Announcements();
        $resources->insert([
            ['user_id' => \App\Users::first()->id, 'body' => 'Welcome to Scaffold', 'action_text' => 'Click here to explore', 'action_url' => 'http://scaffold.app/admin/dashboard', 'read' => false]
        ]);
    }
}
