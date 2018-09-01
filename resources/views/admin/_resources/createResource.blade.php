@extends('layouts.admin')
@section('title') Create {{$resource->getModelName()}} @endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form action="{{ route($resource->getRouteName().'.store') }}" method="POST"
                      enctype="multipart/form-data" onsubmit="return(submitEditForm(this))">
                    @csrf
                    <div class="card-header bg-light">
                        <div class="row">
                            <div class="col-md-4"><h4>Create {{$resource->getModelName()}}</h4></div>
                            <div class="col-md-4"></div>
                            <div class="col-md-4" style="text-align:right;">
                                <button class="btn btn-success" type="submit">Save</button>
                                <a href="{{ route($resource->getRouteName().'.index') }}">
                                    <button class="btn btn-danger" type="button">Cancel</button>
                                </a></div>
                        </div>
                    </div>
                    @if(Session::has('success'))
                        <div class="alert alert-success"> {{ Session::get('success') }}</div>
                    @elseif(Session::has('error'))
                        <div class="alert alert-danger"> {{ Session::get('error') }}</div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-success"> {{ Session::get('success') }}</div>
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
            </div>
            @endif
            <div class="card-body">
                <div class="row">
                    @foreach($resource->getFields() as $field => $fieldName)
                        @if(!array_key_exists ('edited', $fieldName))
                            @if($fieldName['type'] !== 'pivot')
                                @if($fieldName['type'] === 'point')
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6"><h3>Set position: </h3></div>
                                            <div class="col-md-6">
                                                <input onclick="deleteMarkers();" type="button"
                                                       value="Remove marker" class="btn btn-warning"
                                                       style="float:right">
                                            </div>
                                        </div>

                                        <label for="{{$field}}">{{$fieldName['name']}}</label>
                                        <div style="display:none">
                                            <input type="text" id="lat-resource" name="lat">
                                            <input type="text" id="lng-resource" name="lng">
                                        </div>
                                        <div id="{{$field.'-new'}}" style="width:100%;height:400px;"></div>
                                        <script>
                                            var map;
                                            var markers = [];

                                            function myMap() {
                                                var uluru = {lat: -25.344, lng: 131.036};
                                                // The map, centered at Uluru
                                                map = new google.maps.Map(
                                                    document.getElementById("{{$field.'-new'}}"), {
                                                        zoom: 4,
                                                        center: uluru
                                                    });

                                                google.maps.event.addListener(map, 'click', function (event) {
                                                    placeMarker(event.latLng);
                                                });
                                            }

                                            function placeMarker(location) {
                                                deleteMarkers();
                                                var marker = new google.maps.Marker({
                                                    position: location,
                                                    map: map
                                                });
                                                markers.push(marker);

                                                $('#lat-resource').val(location.lat());
                                                $('#lng-resource').val(location.lng());

                                                getCountryId({lat: location.lat(), lng: location.lng()});
                                            }

                                            // Deletes all markers in the array by removing references to them.
                                            function deleteMarkers() {
                                                clearMarkers();
                                                markers = [];
                                                $('#lat-resource').val('');
                                                $('#lng-resource').val('');
                                            }

                                            // Sets the map on all markers in the array.
                                            function setMapOnAll(map) {
                                                for (var i = 0; i < markers.length; i++) {
                                                    markers[i].setMap(map);
                                                }
                                            }

                                            // Removes the markers from the map, but keeps them in the array.
                                            function clearMarkers() {
                                                setMapOnAll(null);
                                            }
                                        </script>
                                        <script src="{{'https://maps.googleapis.com/maps/api/js?key='.env('GOOGLE').'&language=en&callback=myMap'}}"></script>
                                    </div>
                                @elseif($fieldName['type'] === 'editor')
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="editor">{{$fieldName['name']}}</label>
                                            <textarea id="editor" name="{{$field}}"></textarea>
                                        </div>
                                    </div>
                                @elseif($fieldName['type'] === 'pivot-ajax')
                                    <div class="col-md-12" id="org-usr-roles">
                                        <input type="text" style="display: none" id="pivot-input" name="pivot-input">
                                        <div class="card">

                                            <div class="card-header bg-light">
                                                <div class="row">
                                                    <div class="col-md-4">{{$fieldName['name']}}</div>
                                                    <div class="col-md-4"></div>
                                                    <div class="col-md-4">
                                                        <button id="add-pivot-btn" type="button" class="btn btn-success"
                                                                style="float: right"
                                                                data-toggle="modal"
                                                                data-target="{{'#'.$fieldName['div'].'-add-modal'}}"
                                                                disabled>Add
                                                        </button>
                                                    </div>
                                                </div>


                                            </div>

                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                        <tr>
                                                            @foreach($fieldName['header'] as $headItem)
                                                                <th>{{$headItem}}</th>
                                                            @endforeach
                                                        </tr>
                                                        </thead>
                                                        <tbody id="roles-body">
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>


                                        <div class="modal fade" id="pivot-roles-add-modal" tabindex="-1" role="dialog"
                                             aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">New role</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form>
                                                            <div class="form-group">
                                                                <label for="role-id"
                                                                       class="col-form-label">Role:</label>
                                                                <select name="" id="role-id"></select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="start-date" class="col-form-label">Start
                                                                    date:</label>
                                                                <input type="text" class="form-control date"
                                                                       id="start-date">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="end-date" class="col-form-label">End
                                                                    date:</label>
                                                                <input type="text" class="form-control date"
                                                                       id="end-date">
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close
                                                        </button>
                                                        <button type="button" class="btn btn-primary" id="add-role-btn"
                                                                onclick="addRoleBtnClick()">Add
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal fade" id="pivot-roles-edit-modal" tabindex="-1" role="dialog"
                                             aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Edit role</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form>
                                                            <div class="form-group">
                                                                <label for="role-id"
                                                                       class="col-form-label">Role:</label>
                                                                <select name="" id="edit-role-id"></select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="edit-start-date" class="col-form-label">Start
                                                                    date:</label>
                                                                <input type="text" class="form-control date"
                                                                       id="edit-start-date">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="edit-end-date" class="col-form-label">End
                                                                    date:</label>
                                                                <input type="text" class="form-control date"
                                                                       id="edit-end-date">
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close
                                                        </button>
                                                        <button type="button" class="btn btn-primary"
                                                                id="edit-role-btn-save">Save
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @elseif($fieldName['type'] === 'new-pivot')
                                    <div class="col-md-12">
                                        <label for="">{{$fieldName['name']}}</label>
                                        <table class="table">
                                            <tbody>
                                            @foreach($fieldName['elements'] as $element)
                                                <tr>
                                                    <td style="width: 50%">{{$element->name}}</td>
                                                    <td style="width: 50%">
                                                        <div class="toggle-switch" data-ts-color="primary">
                                                            <input id="{{$fieldName['name'].'-'.$element->id}}" name="{{strtolower($fieldName['name']).'[]'}}"
                                                                   type="checkbox"
                                                                   hidden="hidden" value="{{$element->id}}" {{$resource->getPivot(strtolower($fieldName['name']), $element) ? 'checked' : ''}}>
                                                            <label for="{{$fieldName['name'].'-'.$element->id}}" class="ts-helper"></label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </table>
                                    </div>
                                @else
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            @if($fieldName['type'] === 'text' || $fieldName['type'] === 'number')
                                                <label for="{{$field}}">{{$fieldName['name']}}</label>
                                                <input id="{{$field}}" name="{{$field}}" type="{{$fieldName['type']}}"
                                                       class="form-control form-control-sm" {{!array_key_exists ('optional', $fieldName) ? 'required' : ''}}>
                                            @elseif($fieldName['type'] === 'textarea')
                                                <label for="{{$field}}">{{$fieldName['name']}}</label>
                                                <textarea id="{{$field}}" name="{{$field}}" type="text"
                                                          class="form-control"
                                                          cols="30"
                                                          rows="5" {{!array_key_exists ('optional', $fieldName) ? 'required' : ''}}></textarea>
                                            @elseif($fieldName['type'] === 'datetime')
                                                <label for="{{$field}}">{{$fieldName['name']}}</label>
                                                <input id="{{$field}}" name="{{$field}}"
                                                       type='text'
                                                       class="form-control date" {{!array_key_exists ('optional', $fieldName) ? 'required' : ''}}/>
                                            @elseif($fieldName['type'] === 'password')
                                                <label for="{{$field}}">{{$fieldName['name']}}</label>
                                                <input id="{{$field}}" name="{{$field}}"
                                                       type='password'
                                                       class="form-control" {{!array_key_exists ('optional', $fieldName) ? 'required' : ''}}/>
                                            @elseif($fieldName['type'] === 'select')
                                                <label for="{{$field}}"
                                                       class="require">{{$fieldName['name']}}</label>
                                                <select class="{{$field}} form-control"
                                                        id="{{key_exists('as', $fieldName) ? $fieldName['as'] : $field}}"
                                                        name="{{$field}}"
                                                        disabled {{!array_key_exists ('optional', $fieldName) ? 'required' : ''}}>
                                                    @if(method_exists($resource, 'getSelect') && array_key_exists($field, $resource->getSelect()))
                                                        @foreach($resource->getSelect()[$field] as $key => $value)
                                                            <option value="{{$key}}">{{$value}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            @elseif($fieldName['type'] === 'checkbox')
                                                <label for="{{$field}}"
                                                       class="ts-label">{{$fieldName['name']}}</label>
                                                <br>
                                                <div class="toggle-switch" data-ts-color="primary">
                                                    <input id="{{$field}}" name="{{$field}}" type="checkbox"
                                                           hidden="hidden">
                                                    <label for="{{$field}}" class="ts-helper"></label>
                                                </div>
                                            @elseif($fieldName['type'] === 'file')
                                                <div>
                                                    <label for="{{$field}}"
                                                           class="ts-label">{{$fieldName['name']}}</label>
                                                    <br>
                                                    <input id="{{$field}}" name="{{$field}}" type="file"
                                                           accept="image/x-png,image/gif,image/jpeg">
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            @else
                                @if($fieldName['pivot_type'] === 'checkbox')
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="{{$field}}"
                                                   class="ts-label">{{$fieldName['name']}}</label>
                                            <br>
                                            <div class="toggle-switch" data-ts-color="primary">
                                                <input id="{{$field}}" name="{{$field}}" type="checkbox"
                                                       hidden="hidden">
                                                <label for="{{$field}}" class="ts-helper"></label>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection