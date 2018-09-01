@extends('layouts.'.Auth::user()->getRole())
@section('title') Profile @endsection
@section('content')
    <div class="profile">
        @if(fire_auth()->user()->image != 0)
            <img src="{{ asset(Storage::url(fire_auth()->user()->image))}}" class="profile-img">
        @else
            <img src="{{ asset('admin/assets/imgs/avatar-1.png') }}" class="profile-img">
        @endif
        <div class="profile-text">
            <h1 class="profile-name">{{fire_auth()->user()->name}}</h1>
            <span class="profile-title">{{fire_auth()->user()->email}}</span><br><br>
            <span class="profile-title"><a class="btn btn-info" style="color: white" href="{{url('profile/edit')}}">Edit my profile</a></span>
        </div>
    </div>
    </div>
@endsection