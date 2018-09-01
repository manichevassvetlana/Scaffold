@extends('layouts.admin')
@section('title') {{$resource->getModelName()}} @endsection
@section('content')
    <div class="card">
        <div class="card-header bg-light">
            <div class="row">
                <div class="col-md-4"><h4>Manage {{$resource->getModelName()}}</h4></div>
                <div class="col-md-4"></div>
                <div class="col-md-4" style="text-align:right;">
                    @if($resource->getRouteName() != 'users')
                    <a
                            href="{{ route($resource->getRouteName().'.create') }}">
                        <button class="btn btn-success" type="submit">New</button>
                    </a>
                        @endif
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div id="table_wrapper" class="dataTables_wrapper no-footer">
                    <div class="dataTables_length" id="table_length">
                        <form action="{{ route($resource->getRouteName().'.index') }}" method="get" id="count-form"
                              name="count-form">
                            <label>
                                Show
                                <select aria-controls="table" name="count" id="count-resources">
                                    @foreach($countArray as $countValue)
                                        <option value="{{$countValue}}" {{$countValue == $count ? 'selected' : ''}}>{{$countValue}}</option>
                                    @endforeach
                                </select>
                                entries
                                <input type="text" style="display: none" name="start_at" id="page-counter"
                                       value="{{$page}}">
                            </label>
                        </form>
                    </div>
                    <div id="table_filter" class="dataTables_filter">
                        <label>Search:
                            <input type="search" aria-controls="table" id="search-resource"
                                   value="{{$search ? $search : ''}}">
                        </label>
                    </div>


                    <table class="table table-striped" id="table">
                        <thead>
                        <tr>
                            @foreach($resource->getFields() as $field => $fieldName)
                                @if(!array_key_exists ('hidden', $fieldName))
                                    <th>{{$fieldName['name']}}</th>
                                @endif
                            @endforeach
                            <th>Updated at</th>
                            <th>Created at</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($resources as $resource)
                            <tr class="item{{ $resource->id }}">
                                @foreach($resource->getFields() as $field => $fieldName)
                                    @if(!array_key_exists ('hidden', $fieldName))
                                        @if($resource->getRouteName() == 'pages' && $field == 'slug' && $resource->getRelatedName('status') == 'Published')
                                            <td><a href="{{url('/'.$resource->slug)}}"
                                                   style="color: lightblue">{{$resource->slug}}</a></td>
                                        @elseif($fieldName['type'] == 'imperson')
                                            @canImpersonate
                                            @if($resource->id != Auth::user()->id)
                                                <td><a class="btn btn-info"
                                                       href="{{ route('impersonate', $resource->id) }}">Impersonate</a>
                                                </td>
                                            @else
                                                <td></td>
                                            @endif
                                            @endCanImpersonate
                                        @else
                                            <td>{{$fieldName['type'] == 'select' ? $resource->getRelatedName($field) : $resource->$field}}</td>
                                        @endif
                                    @endif
                                @endforeach
                                <td>{{ \Carbon\Carbon::parse($resource->created_at)->diffForHumans() }}</td>
                                <td>{{ \Carbon\Carbon::parse($resource->updated_at)->diffForHumans() }}</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <a href="{{ route($resource->getRouteName().'.edit', $resource->id) }}">
                                                <button class="btn btn-warning" type="button"
                                                        style="float: right">
                                                    Edit
                                                </button>
                                            </a>
                                        </div>
                                        <div class="col-md-9">
                                            @if($resource->isRemovable)
                                                <button class="btn btn-danger" type="submit"
                                                        style="float: left" onclick="removeResource('{{route($resource->getRouteName().'.index'/*'.destroy', $resource->id*/)}}', '{{$resource->id}}')">
                                                    Remove
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>


                    @if($length)
                        <div class="dataTables_paginate paging_simple_numbers" id="table_paginate" style="margin: 1%">
                            <span>
                                <a class="paginate_button current"
                                   aria-controls="table" tabindex="0">-></a>
                            </span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection