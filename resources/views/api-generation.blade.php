@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="col-md-10">
            <div>
                @if(fire_auth()->user()->isGlobalAdmin())
                    <passport-authorized-clients></passport-authorized-clients>
                    <passport-clients></passport-clients>
                @endif
                <passport-personal-access-tokens></passport-personal-access-tokens>
            </div>
        </div>
    </div>
@endsection