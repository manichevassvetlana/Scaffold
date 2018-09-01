<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ResourceController;
use App\OauthAccessToken;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminOauthAccessTokenController extends ResourceController
{
    public function __construct()
    {
        $model = new OauthAccessToken();
        $role = 'admin';
        parent::__construct($model, $role);
    }

    public function store(Request $request)
    {
        ($request->has('revoked') && $request->revoked == 'on') ? $request['revoked'] = 1 : $request['revoked'] = 0;
        
        $user = User::findOrFail($request->user_id);

        $resource = $user->createToken($request->name, []);

        $resource->token->update(['token' => $resource->accessToken, 'expires_at' => $request->expires_at, 'revoked' => $request->revoked]);

        if(request()->is('api/*')){
            return $resource->toJson();
        }

        return redirect()->route($this->model->getRouteName().'.index');
    }

    public function update(Request $request, $id)
    {
        ($request->has('revoked') && $request->revoked == 'on') ? $request['revoked'] = 1 : $request['revoked'] = 0;

        $resource = $this->model->findOrFail($id);
        $resource->update($request->only(['revoked', 'expires_at', 'user_id', 'name']));

        if(request()->is('api/*')){
            return $resource->toJson();
        }

        return back()->with('success', $resource->getModelName().' updated successfully.');
    }

}