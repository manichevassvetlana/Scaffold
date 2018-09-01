<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return fire_auth()->user();
});

// Admin Panel Routes
Route::group(['middleware' => 'auth:api', 'name' => 'api.'], function(){

    //Route::get('/countries', 'Admin\AdminCountryController@countries');
    // Resources
    Route::resources([
        'countries' => 'Admin\AdminCountryController',
        'states' => 'Admin\AdminStateController',
        'cities' => 'Admin\AdminCityController',
        'postal-codes' => 'Admin\AdminPostalCodeController',
        'addresses' => 'Admin\AdminAddressController',
        'counties' => 'Admin\AdminCountyController',
        'locations' => 'Admin\AdminLocationController',
        'entity-relationships' => 'Admin\AdminEntityRelationshipController',
        'lookup-values' => 'Admin\AdminLookupValueController',

        'announcements' => 'Admin\AdminAnnouncementController',
        'notifications' => 'Admin\AdminNotificationController',
        'apis' => 'Admin\AdminAPIController',
        'api-tokens' => 'Admin\AdminAPITokenController',
        'categories' => 'Admin\AdminCategoryController',
        'developers' => 'Admin\AdminDeveloperController',
        'documents' => 'Admin\AdminDocumentController',
        'repositories' => 'Admin\AdminRepositoryController',
        'sdks' => 'Admin\AdminSDKController',
        'users' => 'Admin\AdminUserController',
        'roles' => 'Admin\AdminRoleController',

        'pages' => 'Admin\AdminPageController',

        'plans' => 'Admin\AdminPlanController',
        'abilities' => 'Admin\AdminAbilityController',
        'organizations' => 'Admin\AdminOrganizationController',
        'organization-users' => 'Admin\AdminOrganizationUsersController',
        'subscriptions' => 'Admin\AdminSubscriptionController',
        'organization-role-abilities' => 'Admin\AdminOrganizationRoleAbility',
    ]);

});