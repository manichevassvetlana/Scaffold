@extends('layouts.admin')
@section('title') {{$resource->getModelName()}} @endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{$resource->action_url}}">{{$resource->action_text}}</a>
        </div>
        <div class="card-body">
            {!! $resource->body !!}
        </div>
    </div>
@endsection