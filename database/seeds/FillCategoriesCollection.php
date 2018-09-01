<?php

use Illuminate\Database\Seeder;

class FillCategoriesCollection extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $resources = new \App\Categories();
        $id = $resources->create(['type' => getLookupValue('CATEGORY_TYPE', 'Root')->id, 'parent_id' => null, 'order' => 1, 'name' => 'Root'])->id;
        $id_2 = $resources->create(['type' => getLookupValue('CATEGORY_TYPE', 'Announcement')->id, 'parent_id' => $id, 'order' => 1, 'name' => 'All Announcements'])->id;
        $resources->insert([
            ['type' => getLookupValue('CATEGORY_TYPE', 'Notification')->id, 'parent_id' => $id, 'order' => 1, 'name' => 'All Notifications'],
            ['type' => getLookupValue('CATEGORY_TYPE', 'Announcement')->id, 'parent_id' => $id_2, 'order' => 1, 'name' => 'New Features'],
            ['type' => getLookupValue('CATEGORY_TYPE', 'Announcement')->id, 'parent_id' => $id_2, 'order' => 2, 'name' => 'New Products'],
            ['type' => getLookupValue('CATEGORY_TYPE', 'Document')->id, 'parent_id' => $id, 'order' => 1, 'name' => 'All Documents'],
            ['type' => getLookupValue('CATEGORY_TYPE', 'Document')->id, 'parent_id' => $id_2, 'order' => 1, 'name' => 'API Documents'],
        ]);
        $resources->findOrFail($id)->update(['parent_id' => $id]);
    }
}
