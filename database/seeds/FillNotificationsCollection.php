<?php

use Illuminate\Database\Seeder;

class FillNotificationsCollection extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $resources = new \App\Notifications();
        $resources->insert([
            ['user_id' => \App\Users::first()->id, 'created_by' => \App\Users::first()->id, 'icon' => 'fas fa-exclamation-triangle', 'body' => 'WARNING: <Warning Text>', 'action_text' => 'Click here to see more', 'action_url' => 'http://localhost.app', 'read' => 0]
        ]);
    }
}
