<?php

namespace App\Http\Controllers;

use App\Mail\InvitationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function invite(Request $request)
    {
        $receiver = $request->receiver;
        try{
            $invitation = new \stdClass();
            $invitation->organization = Auth::user()->organizationUser->organization->name;
            Mail::to($receiver)->send(new InvitationMail($invitation));
        }
        catch(\Exception $e){

        }
    }
}
