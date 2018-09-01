<?php

namespace App\Http\Controllers\Admin;

use App\Announcements;
use App\Documents;
use App\Notifications;
use App\Users;
use App\Http\Controllers\Controller;

class AdminDashboardController extends Controller
{
    public function dashboard() {
        $users = Users::all();
        $announcements = Announcements::all();
        $documents = Documents::all();
        $notifications = Notifications::all();
        return view('admin.dashboard', compact(['users','announcements','documents','notifications']));
    }
}
