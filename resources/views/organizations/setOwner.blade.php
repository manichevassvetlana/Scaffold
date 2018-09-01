@extends('layouts.user')
@if(fire_auth()->user()->getOrganizationByStatus('Pending'))
@section('title') Organization {{fire_auth()->user()->getOrganizationByStatus('Pending')->name}}@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-light">
                    <div class="row">
                        <div class="col-md-4"><h4>
                                Organization {{fire_auth()->user()->getOrganizationByStatus('Pending')->name}}</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="domain">Do you want to become the Owner
                                    of {{fire_auth()->user()->getOrganizationByStatus('Pending')->name}}?</label><br><br>
                                <form action="{{ route('organization.set-owner') }}"
                                      method="POST">
                                    @csrf
                                    {{ method_field('PUT') }}
                                    <button class="btn btn-success" type="submit">Become the Owner</button>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div>
                                    <label for="email">Invite the Owner
                                        of {{fire_auth()->user()->getOrganizationByStatus('Pending')->name}}</label>
                                    <input id="email-owner" name="email" class="form-control"
                                           placeholder="{{ 'email@'.fire_auth()->user()->getOrganizationByStatus('Pending')->domain }}"><br>
                                    <button class="btn btn-info" type="submit" onclick="sendInvitation()">
                                        <div class="loader" id="loader-owner-invite" style="display:none">
                                        </div>
                                        <div class="loaded" id="btn-owner-invite">Invite</div></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@endif