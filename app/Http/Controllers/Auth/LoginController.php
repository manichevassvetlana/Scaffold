<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Lcobucci\JWT\Parser;
use WebsolutionsGroup\Auth\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    public $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function setUser(Request $request)
    {
        return $this->setToken($request->access_token);
    }

    public function setToken($token)
    {
        if (!isset($_SESSION)) session_start();
        if(!Auth::checkByToken($token)) return '/login';
        $_SESSION['access_token'] = $token;
        return $this->redirectTo;
    }

    public function logout()
    {
        if (!isset($_SESSION)) session_start();
        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            unset($_SESSION['access_token']);
            return redirect('/');
        } else {
            return redirect('/');
        }
    }
}
