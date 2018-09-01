<?php

namespace App\Http\Controllers\Auth;

use App\Events\NotificationCreate;
use App\Http\Controllers\Controller;
use App\Http\Controllers\OrganizationController;
use App\Notification;
use App\Organization;
use App\Organizations;
use App\OrganizationUser;
use App\User;
use App\Users;
use GPBMetadata\Google\Api\Auth;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Lcobucci\JWT\Parser;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users|not_email',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return $user;
    }

    public function createUser(Request $request)
    {
        $token = (new Parser())->parse((string) $request->access_token);
        $uid = $token->getClaim('user_id');
        $email = $token->getClaim('email');

        $user = Users::create(['id' => $uid, 'email' => $email, 'name' => $request->name], false);

        $domain = mb_substr(stristr($email, '@'), 1);

        $org = Organizations::where('domain', $domain)->first();

        $loginController = new LoginController();
        if (!is_null($org)) {
            $orgUser = $org->users()->where('organization.type', getLookupValue('ORG_USER_TYPE', 'Owner')->id)->first();
            OrganizationController::addUserToOrganization($user, $org, 'Standard');
            !is_null($orgUser) ? OrganizationController::sendNotifications($org, $orgUser, $user) : $loginController->redirectTo = '/organization/owner';
        } else {
            OrganizationController::addOrganization($domain, $user);
            $loginController->redirectTo = '/organization/edit';
        }

        return $loginController->setToken($request->access_token);
    }

}
