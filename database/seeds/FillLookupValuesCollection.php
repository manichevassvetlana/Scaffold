<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class FillLookupValuesCollection extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $resources = new \App\LookupValues();
        $resources->insert([
            ['type' => 'ORG_USER_STATUS', 'value' => 'Active', 'description' => ' ', 'starts_at' => \Carbon\Carbon::now(), 'ends_at' => null],
            ['type' => 'ORG_USER_STATUS', 'value' => 'Not Active', 'description' => ' ', 'starts_at' => \Carbon\Carbon::now(), 'ends_at' => null],
            ['type' => 'ORG_USER_STATUS', 'value' => 'Pending', 'description' => ' ', 'starts_at' => \Carbon\Carbon::now(), 'ends_at' => null],
            ['type' => 'ORG_USER_TYPE', 'value' => 'Owner', 'description' => ' ', 'starts_at' => \Carbon\Carbon::now(), 'ends_at' => null],
            ['type' => 'ORG_USER_TYPE', 'value' => 'Superadmin', 'description' => ' ', 'starts_at' => \Carbon\Carbon::now(), 'ends_at' => null],
            ['type' => 'ORG_USER_TYPE', 'value' => 'Admin', 'description' => ' ', 'starts_at' => \Carbon\Carbon::now(), 'ends_at' => null],
            ['type' => 'ORG_USER_TYPE', 'value' => 'Standard', 'description' => ' ', 'starts_at' => \Carbon\Carbon::now(), 'ends_at' => null],

            ['type' => 'ORG_STATUS', 'value' => 'Active', 'description' => ' ', 'starts_at' => \Carbon\Carbon::now(), 'ends_at' => null],
            ['type' => 'ORG_TYPE', 'value' => 'Personal', 'description' => ' ', 'starts_at' => \Carbon\Carbon::now(), 'ends_at' => null],
            ['type' => 'ORG_TYPE', 'value' => 'Business', 'description' => ' ', 'starts_at' => \Carbon\Carbon::now(), 'ends_at' => null],
            ['type' => 'ORG_TYPE', 'value' => 'Non-Profit', 'description' => ' ', 'starts_at' => \Carbon\Carbon::now(), 'ends_at' => null],

            ['type' => 'PAGE_TYPE', 'value' => 'about', 'description' => 'About Page Type', 'starts_at' => \Carbon\Carbon::now(), 'ends_at' => null],
            ['type' => 'PAGE_TYPE', 'value' => 'main', 'description' => 'Main Page Type', 'starts_at' => \Carbon\Carbon::now(), 'ends_at' => null],
            ['type' => 'PAGE_LAYOUT', 'value' => 'admin', 'description' => 'Admin Page Layout', 'starts_at' => \Carbon\Carbon::now(), 'ends_at' => null],
            ['type' => 'PAGE_LAYOUT', 'value' => 'app', 'description' => 'App Page Layout', 'starts_at' => \Carbon\Carbon::now(), 'ends_at' => null],

            ['type' => 'PAGE_STATUS', 'value' => 'Published', 'description' => ' ', 'starts_at' => \Carbon\Carbon::now(), 'ends_at' => null],
            ['type' => 'PAGE_STATUS', 'value' => 'Draft', 'description' => ' ', 'starts_at' => \Carbon\Carbon::now(), 'ends_at' => null],

            ['type' => 'PLAN_STATUS', 'value' => 'Active', 'description' => ' ', 'starts_at' => \Carbon\Carbon::now(), 'ends_at' => null],
            ['type' => 'PLAN_STATUS', 'value' => 'Inactive', 'description' => ' ', 'starts_at' => \Carbon\Carbon::now(), 'ends_at' => null],
            ['type' => 'PLAN_TYPE', 'value' => 'Personal', 'description' => ' ', 'starts_at' => \Carbon\Carbon::now(), 'ends_at' => null],
            ['type' => 'PLAN_TYPE', 'value' => 'Business', 'description' => ' ', 'starts_at' => \Carbon\Carbon::now(), 'ends_at' => null],
            ['type' => 'PLAN_TYPE', 'value' => 'Non-Profit', 'description' => ' ', 'starts_at' => \Carbon\Carbon::now(), 'ends_at' => null],

            ['type' => 'ROLE_TYPE', 'value' => 'User', 'description' => 'Global User Role Type', 'starts_at' => \Carbon\Carbon::now(), 'ends_at' => null],
            ['type' => 'ROLE_TYPE', 'value' => 'Organization', 'description' => 'Organization User Role Type', 'starts_at' => \Carbon\Carbon::now(), 'ends_at' => null],

            ['type' => 'SUBSCRIPTION_STATUS', 'value' => 'Active', 'description' => ' ', 'starts_at' => \Carbon\Carbon::now(), 'ends_at' => null],

            ['type' => 'CATEGORY_TYPE', 'value' => 'Root', 'description' => '', 'starts_at' => Carbon::now(), 'ends_at' => null],
            ['type' => 'CATEGORY_TYPE', 'value' => 'Announcement', 'description' => 'Announcement category type to be used in type dropdown lists.', 'starts_at' => Carbon::now(), 'ends_at' => null],
            ['type' => 'CATEGORY_TYPE', 'value' => 'Notification', 'description' => 'Notification category type to be used in type dropdown lists.', 'starts_at' => Carbon::now(), 'ends_at' => null],
            ['type' => 'CATEGORY_TYPE', 'value' => 'Document', 'description' => 'Document category type to be used in type dropdown lists.', 'starts_at' => Carbon::now(), 'ends_at' => null],
            ['type' => 'API_TYPE', 'value' => 'Public', 'description' => 'Public API type to be used in type dropdown lists.', 'starts_at' => Carbon::now(), 'ends_at' => null],
            ['type' => 'API_TYPE', 'value' => 'Private', 'description' => 'Private API type to be used in type dropdown lists.', 'starts_at' => Carbon::now(), 'ends_at' => null],
            ['type' => 'DOCUMENT_TYPE', 'value' => 'Document', 'description' => 'Default Document type to be used in type dropdown lists.', 'starts_at' => Carbon::now(), 'ends_at' => null],
            ['type' => 'REFERENCE_TYPE', 'value' => 'App\API', 'description' => 'API Reference type to be used in type dropdown lists.', 'starts_at' => Carbon::now(), 'ends_at' => null],
            ['type' => 'REFERENCE_MODEL', 'value' => 'API', 'description' => 'API Reference model', 'starts_at' => Carbon::now(), 'ends_at' => null],
            ['type' => 'REPOSITORY_TYPE', 'value' => 'Git', 'description' => 'Git Repository type to be used in type dropdown lists.', 'starts_at' => Carbon::now(), 'ends_at' => null],
            ['type' => 'REPOSITORY_TYPE', 'value' => 'Svn', 'description' => 'SVN Repository type to be used in type dropdown lists.', 'starts_at' => Carbon::now(), 'ends_at' => null],
            ['type' => 'REPOSITORY_TYPE', 'value' => 'TFS', 'description' => 'TFS Repository type to be used in type dropdown lists.', 'starts_at' => Carbon::now(), 'ends_at' => null],
            ['type' => 'SDK_TYPE', 'value' => 'php', 'description' => 'PHP SKD type to be used in type dropdown lists.', 'starts_at' => Carbon::now(), 'ends_at' => null],
            ['type' => 'SDK_TYPE', 'value' => 'python', 'description' => 'Python SDK type to be used in type dropdown lists.', 'starts_at' => Carbon::now(), 'ends_at' => null],

            ['type' => 'ROLE_TYPE', 'value' => 'Organization', 'description' => '', 'starts_at' => Carbon::now(), 'ends_at' => null],
            ['type' => 'ROLE_TYPE', 'value' => 'User', 'description' => '', 'starts_at' => Carbon::now(), 'ends_at' => null],
        ]);
    }
}
