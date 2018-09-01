@extends('layouts.'.Auth::user()->getRole())
@section('title') Edit Profile @endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{ method_field('PUT') }}
                    <div class="card-header bg-light">
                        <div class="row">
                            <div class="col-md-4"><h4>Edit Profile</h4></div>
                            <div class="col-md-4"></div>
                            <div class="col-md-4" style="text-align:right;">
                                <button class="btn btn-success" type="submit">Save</button>
                                <a href="{{ url('profile') }}">
                                    <button class="btn btn-danger" type="button">Cancel</button>
                                </a></div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="user-name" class="require">User Image</label>
                                    <img src="{{ fire_auth()->user()->image != 0 ? asset(Storage::url(fire_auth()->user()->image)) : asset('admin/assets/imgs/avatar-1.png') }}"
                                         class="profile-img"
                                         style="margin-left: 0; margin-bottom: 5%; cursor: pointer; width: 150px; height: 150px;"
                                         onclick="document.getElementById('file-input').click()" id="user-img">
                                    <input name="image" id="file-input" type="file" style="display:none"
                                           accept="image/x-png,image/gif,image/jpeg">
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="user-name" class="require">User Name</label>
                                    <input id="user-name" name="name" class="form-control"
                                           value="{{ fire_auth()->user()->name }}" style="width: 33%">
                                </div>
                            </div>
                            <br>
                            <br>
                            @if(fire_auth()->user()->organizationUser && fire_auth()->user()->organizationUser->status != getLookupValue('ORG_USER_STATUS', 'Not Active')->id)
                                <div id="org-section" style="width: 90%">
                                    <div style="padding: 2% 0; border: solid 1px #ced4da; margin: 1.3%; width: 100%;">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="user-email" class="require">Organization</label><br>
                                                <b>Status:</b> {{fire_auth()->user()->organizationUser->lookupStatus->value}} user<br><br>
                                                <input class="form-control" style="width: 33%; float: left; margin-right: 10px" disabled
                                                       value="{{fire_auth()->user()->organizationUser->organization->name}}">
                                                <a class="btn btn-danger" style="float: left" id="leave-company">Leave the company</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
            </div>
        </div>
    </div>
@endsection