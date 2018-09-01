<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('home');
    }

    public function dashboard()
    {
        $userRole = 'user';
        $user = fire_auth()->user();
        switch (true) {
            case $user->isRole('Admin'):
                $userRole = 'admin';
                break;
            case $user->isRole('Developer'):
                $userRole = 'developer';
                break;
            case $user->isRole('Analyst'):
                $userRole = 'analyst';
                break;
            case $user->isRole('Clerk'):
                $userRole = 'clerk';
                break;
        }
        return redirect()->route($userRole.'Dashboard');
    }
}
