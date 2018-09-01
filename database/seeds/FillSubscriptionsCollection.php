<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class FillSubscriptionsCollection extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $resources = new \App\Subscriptions();
        // Add subscriptions to ORG
        $resources->insert([[
            'organization_id' => \App\Organizations::first()->id, 'plan_id' => \App\Plans::first()->id, 'status' => getLookupValue('PLAN_STATUS', 'Active')->id, 'start_date' => Carbon::now(), 'end_date' => null, 'renewal_date' => null, 'cancelled_date' => null
        ]]);
    }
}
