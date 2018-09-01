<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::post('/log-in', 'Auth\LoginController@setUser');
Route::post('/sign-up', 'Auth\RegisterController@createUser');

Route::group(['prefix' => 'mail', 'middleware' => 'auth'], function () {
    Route::post('/invitation', 'EmailController@invite');
});

Route::post('/pay/{plan}', [
    'uses' => 'PlanController@postPayWithStripe',
    'as' => 'pay',
    'middleware' => 'auth'
]);


Route::get('/plans', function () {
    return view('test-payment', ['plans' => \App\Plans::all()]);
});

Route::get('/tokens/generate', function () {
    return view('api-generation');
})->name('token-generate');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');


// Developer Panel Routes
Route::prefix('user')->group(function () {
    Route::get('/dashboard', 'UserController@dashboard')->name('userDashboard');
});

Route::get('/user/notifications', 'Admin\AdminUserController@notifications');
Route::put('/notifications/{notification}/read', 'Admin\AdminNotificationController@read');
Route::get('/user/announcements', 'Admin\AdminUserController@announcements');
Route::put('/announcements/{announcement}/read', 'Admin\AdminAnnouncementController@read');
Route::get('/announcement/{announcement}', 'Admin\AdminAnnouncementController@announcement');

// Admin Panel Routes
Route::group(['prefix' => 'admin', 'middleware' => 'checkRole:Admin'], function () {

    Route::put('/organization-user/{id}/check', 'Admin\AdminOrganizationUsersController@checkUser');

    Route::get('/code-county/{code}', 'Admin\AdminCountryController@findByCode');
    Route::put('/pages/{page}/version', 'Admin\AdminPageController@updateVersion');

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
        'oauth-access-tokens' => 'Admin\AdminOauthAccessTokenController',

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

    Route::put('/organization-user-roles/{role}/update', 'Admin\AdminOrganizationController@editRole');
    Route::post('/organization-user-roles/validate', 'Admin\AdminOrganizationController@roleValidation');
    Route::post('/organization-user-roles/{role}', 'Admin\AdminOrganizationController@destroyRole');

    Route::get('/organization/{org_id}/role/{role_id}', 'Admin\AdminOrganizationController@roleAbility');

    // Dashboard
    Route::get('/dashboard', 'Admin\AdminDashboardController@dashboard')->name('adminDashboard');
});

// Analyst Panel Routes
Route::prefix('analyst')->group(function () {
    Route::get('/dashboard', 'AnalystController@dashboard')->name('analystDashboard');
});

// Clerk Panel Routes
Route::prefix('clerk')->group(function () {
    Route::get('/dashboard', 'ClerkController@dashboard')->name('clerkDashboard');
});

// Developer Panel Routes
Route::prefix('developer')->group(function () {
    Route::get('/dashboard', 'DeveloperController@dashboard')->name('developerDashboard');
});


Route::group(['prefix' => 'profile', 'middleware' => 'auth'], function () {
// User Profile routes
    Route::get('/', 'Admin\AdminUserController@profile')->name('profile.index');
    Route::get('/edit', 'Admin\AdminUserController@editProfile')->name('profile.edit');
    Route::put('/update', 'Admin\AdminUserController@updateProfile')->name('profile.update');
});

Route::group(['prefix' => 'organization', 'middleware' => 'auth'], function () {
// User Profile routes
    Route::get('/edit', 'OrganizationController@edit');
    Route::get('/owner', 'OrganizationController@viewForOwner');
    Route::put('/leave', 'OrganizationController@leave');
    Route::put('/{organization}/update', 'OrganizationController@update')->name('organization.update');
    Route::put('/set-owner', 'OrganizationController@setOwner')->name('organization.set-owner');
    Route::post('/{organization}/invite-owner', 'OrganizationController@inviteOwner')->name('organization.invite-owner');
    Route::get('/user-confirm/{user}', 'OrganizationController@confirmUser');
});

Route::group(['middleware' => 'checkRole:admin'], function () {
// User Profile routes
    Route::get('/impersonate/{user}', 'Admin\AdminUserController@impersonate')->name('impersonate');
});

Route::get('/impersonate-leave', 'Admin\AdminUserController@impersonateLeave')->name('impersonate-leave');

Route::impersonate();

// Front pages
Route::get('/{slug}', 'PageController@index');

