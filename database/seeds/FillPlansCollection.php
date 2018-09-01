<?php

use Illuminate\Database\Seeder;

class FillPlansCollection extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $resources = new \App\Plans();
        $resources->insert([
            [
                'type' => getLookupValue('PLAN_TYPE', 'Personal')->id,
                'name' => 'Personal - Free Trial',
                'user_quantity' => 5,
                'renewal_frequency' => 0,
                'amount' => 0.00,
                'status' => getLookupValue('PLAN_STATUS', 'Active')->id,
                
                ],
            [
                'type' => getLookupValue('PLAN_TYPE', 'Personal')->id,
                'name' => 'Personal - Monthly',
                'user_quantity' => 5,
                'renewal_frequency' => 14,
                'amount' => 9.99,
                'status' => getLookupValue('PLAN_STATUS', 'Active')->id,
                
                ],
            [
                'type' => getLookupValue('PLAN_TYPE', 'Business')->id,
                'name' => 'Business - Free Trial',
                'user_quantity' => 0,
                'renewal_frequency' => 0,
                'amount' => 0.00,
                'status' => getLookupValue('PLAN_STATUS', 'Active')->id,
                
                ],
            [
                'type' => getLookupValue('PLAN_TYPE', 'Business')->id,
                'name' => 'Business - Monthly',
                'user_quantity' => 0,
                'renewal_frequency' => 14,
                'amount' => 29.99,
                'status' => getLookupValue('PLAN_STATUS', 'Active')->id,
                
                ],
            [
                'type' => getLookupValue('PLAN_TYPE', 'Non-Profit')->id,
                'name' => 'Non-Profit - Free Trial',
                'user_quantity' => 0,
                'renewal_frequency' => 0,
                'amount' => 0.00,
                'status' => getLookupValue('PLAN_STATUS', 'Active')->id,
                
                ],
            [
                'type' => getLookupValue('PLAN_TYPE', 'Non-Profit')->id,
                'name' => 'Non-Profit - Monthly',
                'user_quantity' => 0,
                'renewal_frequency' => 14,
                'amount' => 9.99,
                'status' => getLookupValue('PLAN_STATUS', 'Active')->id,
                
                ],
        ]);
    }
}
