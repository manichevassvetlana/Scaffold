@extends('layouts.user')
@section('title') New Organization @endsection
@section('content')
    @if(fire_auth()->user()->getOrganizationByType('Owner'))
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <form action="{{ route('organization.update', fire_auth()->user()->getOrganizationByType('Owner')->id) }}" method="POST">
                        @csrf
                        {{ method_field('PUT') }}
                        <div class="card-header bg-light">
                            <div class="row">
                                <div class="col-md-4"><h4>Organization</h4></div>
                                <div class="col-md-4"></div>
                                <div class="col-md-4" style="text-align:right;">
                                    <button class="btn btn-success" type="submit">Save</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="domain">Organization Domain</label>
                                        <input id="domain" name="domain" class="form-control"
                                               value="{{ fire_auth()->user()->getOrganizationByType('Owner')->domain }}" style="width: 33%"
                                               disabled>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">Organization Name</label>
                                        <input id="name" name="name" class="form-control"
                                               value="{{ fire_auth()->user()->getOrganizationByType('Owner')->name }}" style="width: 33%">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="type" class="require">Organization Type</label><br>
                                        <select name="type" id="type" class="form-control" style="width: 33%">
                                            @foreach(fire_auth()->user()->getOrganizationByType('Owner')->getSelect()['type'] as $key => $value)
                                                <option value="{{$key}}" {{fire_auth()->user()->getOrganizationByType('Owner')->type == $key ? 'selected' : ''}}>{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    @endif
@endsection