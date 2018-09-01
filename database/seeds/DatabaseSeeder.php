<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(FillUsersCollection::class);
        $this->call(FillEntityRelationshipsCollection::class);
        $this->call(FillCountriesCollection::class);
        $this->call(FillStatesCollection::class);
        $this->call(FillCountiesCollection::class);
        $this->call(FillPostalCodesCollection::class);
        $this->call(FillAddressesCollection::class);
        $this->call(FillLocationsCollection::class);
        $this->call(FillAnnouncementsCollection::class);
        $this->call(FillNotificationsCollection::class);
        $this->call(FillLookupValuesCollection::class);
        $this->call(FillCategoriesCollection::class);
        $this->call(FillDevelopersCollection::class);
        $this->call(FillAPIsCollection::class);
        $this->call(FillDocumentsCollection::class);
        $this->call(FillRepositoriesCollection::class);
        $this->call(FillSDKsCollection::class);
        $this->call(FillRolesCollection::class);
        $this->call(FillPagesCollection::class);
        $this->call(FillOrganizationsCollection::class);
        $this->call(FillAbilitiesCollection::class);
        $this->call(FillPlansCollection::class);
    }
}
