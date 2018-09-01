@extends('layouts.admin')
@section('title') Editing {{ $resource->id }} @endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form action="{{ route($resource->getRouteName().'.update', $resource->id) }}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    {{ method_field('PUT') }}
                    <div class="card-header bg-light">
                        <div class="row">
                            <div class="col-md-4"><h4>Edit {{$resource->getModelName()}}
                                    - {{ $resource->id }}</h4></div>
                            <div class="col-md-4"></div>
                            <div class="col-md-4" style="text-align:right;">
                                @if($resource->getRouteName() == 'pages')
                                    <button class="btn btn-info" type="button"
                                            data-toggle="modal" data-target="#page-version-modal"
                                            data-whatever="@mdo">Select version
                                    </button>
                                @endif
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
                                                               value="Remove marker"
                                                               class="btn btn-warning" style="float:right">
                                                    </div>
                                                </div>
                                                <label for="{{$field}}">{{$fieldName['name']}}</label>
                                                <div style="display:none">
                                                    <input type="text" id="lat-resource" name="lat"
                                                           value="{{$resource->latitude}}">
                                                    <input type="text" id="lng-resource" name="lng"
                                                           value="{{$resource->longitude}}">
                                                </div>
                                                <div id="{{$field.'-'.$resource->id}}"
                                                     style="width:100%;height:400px;"></div>
                                                <script>
                                                    var map;
                                                    var markers = [];

                                                    function myMap() {
                                                        var uluru = {
                                                            @if(!is_null($resource->latitude))
                                                            lat: parseFloat('{{$resource->latitude}}'),
                                                            lng: parseFloat('{{$resource->longitude}}')
                                                            @else
                                                            lat: -25.344, lng: 131.036
                                                            @endif
                                                        };

                                                        // The map, centered at Uluru
                                                        map = new google.maps.Map(
                                                            document.getElementById("{{$field.'-'.$resource->id}}"), {
                                                                zoom: 4,
                                                                center: uluru
                                                            });

                                                        @if(!is_null($resource->latitude))
                                                        // The marker, positioned at Uluru
                                                        var marker = new google.maps.Marker({
                                                            position: uluru,
                                                            map: map
                                                        });
                                                        markers.push(marker);
                                                        @endif

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

                                                        getCountryId({
                                                            lat: location.lat(),
                                                            lng: location.lng()
                                                        });
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
                                                <script src="{{'https://maps.googleapis.com/maps/api/js?key='.env('GOOGLE_MAPS_KEY').'&language=en&callback=myMap'}}"></script>
                                            </div>
                                        @elseif($fieldName['type'] === 'editor')
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="editor">{{$fieldName['name']}}</label>
                                                    <textarea id="editor"
                                                              name="{{$field}}">{{ key_exists('as', $fieldName) ? $resource->{$fieldName['as']} : $resource->$field }}</textarea>
                                                </div>
                                            </div>
                                        @elseif($fieldName['type'] === 'non-edited-text')
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="{{$field}}">{{$fieldName['name']}}</label>
                                                    <input id="{{$field}}" name="{{$field}}"
                                                           type="text"
                                                           class="form-control form-control"
                                                           value="{{ $resource->$field }}" disabled>
                                                </div>
                                            </div>
                                        @elseif($fieldName['type'] === 'pivot-table')
                                            <div class="col-md-12">
                                                <table class="table">
                                                    <tbody>
                                                    @foreach($fieldName['elements'] as $element)
                                                        <tr>
                                                            <td>{{$element['name']}}</td>
                                                            <td>
                                                                <div class="toggle-switch" data-ts-color="primary">
                                                                    <input id="{{$element['name']}}"
                                                                           name="{{$element['name']}}" type="checkbox"
                                                                           hidden="hidden">
                                                                    <label for="{{$element['name']}}"
                                                                           class="ts-helper"></label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-warning">Manage Abilities
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @elseif($fieldName['type'] === 'new-pivot')
                                            <div class="col-md-12">
                                                <br>
                                                <br>
                                                <label for="">{{$fieldName['name']}}</label>
                                                <table class="table">
                                                    <tbody>
                                                    @foreach($fieldName['elements'] as $element)
                                                        <tr>
                                                            <td style="width: 33.3%">{{$element->name}}</td>
                                                            <td style="width: 33.3%">
                                                                <div class="toggle-switch" data-ts-color="primary">
                                                                    <input id="{{$fieldName['name'].'-'.$element->id}}"
                                                                           name="{{strtolower($fieldName['name']).'[]'}}"
                                                                           type="checkbox"
                                                                           hidden="hidden"
                                                                           value="{{$element->id}}" {{$resource->getPivot(strtolower($fieldName['name']), $element) !== false ? 'checked' : ''}}>
                                                                    <label for="{{$fieldName['name'].'-'.$element->id}}"
                                                                           class="ts-helper"></label>
                                                                </div>
                                                            </td>
                                                            <td style="width: 33.3%">
                                                                @if(key_exists('manageble', $fieldName))
                                                                    <a class="btn btn-warning"
                                                                       href="/admin/organization/{{$resource->id}}/role/{{$element->id}}">{{$fieldName['manage_text']}}</a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @elseif($fieldName['type'] === 'user-organization')
                                            <div class="col-md-12">
                                                <br>
                                                <br>
                                                <label for="">{{$fieldName['name']}}</label>
                                                <table class="table">
                                                    <tbody>
                                                    @foreach($fieldName['elements'] as $k => $element)
                                                        <tr>
                                                            <td>{{$element['name']}}</td>
                                                            <td>
                                                                @if($element['type'] === 'datetime')
                                                                    <input id="{{$k}}" name="organization[{{$k}}]"
                                                                           type='text' class="form-control date"
                                                                           value="{{ $resource->organization[$k] }}"/>
                                                                @elseif($element['type'] === 'select')
                                                                    <select class="{{$k}} form-control"
                                                                            id="{{$k}}"
                                                                            name="organization[{{$k}}]">
                                                                        @if(!is_null($resource->organization()))
                                                                            <option value="{{ $resource->organization[$k]}}"
                                                                                    selected>{{$resource->getRelatedName($k)}}</option>
                                                                        @endif
                                                                        @if(key_exists('values', $element))
                                                                            @foreach($element['values'] as $value)
                                                                                @if($resource->organization[$k] != $value->id)
                                                                                    <option value="{{$value->id}}">{{is_null($value->name) ? $value->value : $value->name}}</option>
                                                                                @endif
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @elseif($fieldName['type'] === 'pivot-ajax')
                                            <div class="col-md-12" id="org-usr-roles">
                                                <input type="text" style="display: none" id="pivot-input"
                                                       name="pivot-input">
                                                <div class="card">
                                                    <div class="card-header bg-light">
                                                        <div class="row">
                                                            <div class="col-md-4">{{$fieldName['name']}}</div>
                                                            <div class="col-md-4"></div>
                                                            <div class="col-md-4">
                                                                <button type="button" class="btn btn-success"
                                                                        style="float: right"
                                                                        data-toggle="modal"
                                                                        data-target="{{'#'.$fieldName['div'].'-add-modal'}}">
                                                                    Add
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
                                                                @foreach(is_array($resource->organization['roles']) ? $resource->organization['roles'] : [] as $k => $role)
                                                                    <tr class="{{$role['end_date'] != 0 && new DateTime($role['end_date']) < new DateTime('now') ? 'table-active' : ''}}">
                                                                        <td>{{$role['role']->snapshot()->name}}</td>
                                                                        <td>{{$role['start_date']}}</td>
                                                                        <td>{{$role['end_date']}}</td>
                                                                        <td>
                                                                            <button type="button"
                                                                                    class="btn btn-warning"
                                                                                    data-toggle="modal"
                                                                                    data-target="#pivot-roles-edit-modal"
                                                                                    data-role-id="{{$role['role']->snapshot()->id}}"
                                                                                    data-start-date="{{$role['start_date']}}"
                                                                                    data-end-date="{{$role['end_date']}}"
                                                                                    data-recorded="true"
                                                                                    data-id="{{$k}}"
                                                                                    id="old-record-{{$k}}">Edit
                                                                            </button>
                                                                        </td>
                                                                        <td><a class="btn btn-danger"
                                                                               onclick="removeBtnClick('{{$k}}', true, this)">Remove</a>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="modal fade" id="pivot-roles-add-modal" tabindex="-1"
                                                     role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">New
                                                                    role</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form>
                                                                    <div class="form-group">
                                                                        <label for="role-id" class="col-form-label">Role:</label>
                                                                        <select name="" id="role-id">
                                                                            @foreach(is_array($resource->getOrganizationRoles()) ? $resource->getOrganizationRoles() : [] as $role)
                                                                                <option value="{{$role['role']->snapshot()->id}}">{{$role['role']->snapshot()->name}}</option>
                                                                            @endforeach
                                                                        </select>
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
                                                                <button type="button" class="btn btn-primary"
                                                                        id="add-role-btn" onclick="addRoleBtnClick()">
                                                                    Add
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal fade" id="pivot-roles-edit-modal" tabindex="-1"
                                                     role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Edit
                                                                    role</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form>
                                                                    <div class="form-group">
                                                                        <label for="role-id" class="col-form-label">Role:</label>
                                                                        <select name="" id="edit-role-id">
                                                                            @foreach(is_array($resource->getOrganizationRoles()) ? $resource->getOrganizationRoles() : [] as $role)
                                                                                <option value="{{$role['role']->snapshot()->id}}">{{$role['role']->snapshot()->name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="edit-start-date"
                                                                               class="col-form-label">Start
                                                                            date:</label>
                                                                        <input type="text" class="form-control date"
                                                                               id="edit-start-date">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="edit-end-date"
                                                                               class="col-form-label">End date:</label>
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
                                            <script>
                                                document.addEventListener("DOMContentLoaded", function (event) {
                                                    organizationId = '{{$resource->organization['id']}}';
                                                    organizationUserId = '{{$resource->id}}';
                                                });
                                            </script>
                                        @else
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    @if($fieldName['type'] === 'text' || $fieldName['type'] === 'number')
                                                        <label for="{{$field}}">{{$fieldName['name']}}</label>
                                                        <input id="{{$field}}" name="{{$field}}"
                                                               type="{{$fieldName['type']}}"
                                                               class="form-control form-control-sm"
                                                               value="{{ key_exists('as', $fieldName) ? $resource->{$fieldName['as']} : $resource->$field }}" {{!array_key_exists ('optional', $fieldName) ? 'required' : ''}}>
                                                    @elseif($fieldName['type'] === 'textarea')
                                                        <label for="{{$field}}">{{$fieldName['name']}}</label>
                                                        <textarea id="{{$field}}" name="{{$field}}" type="text"
                                                                  class="form-control"
                                                                  cols="30"
                                                                  rows="5" {{!array_key_exists ('optional', $fieldName) ? 'required' : ''}}>{{key_exists('as', $fieldName) ? $resource->{$fieldName['as']} : $resource->$field}}
                                                    </textarea>
                                                    @elseif($fieldName['type'] === 'datetime')
                                                        <label for="{{$field}}">{{$fieldName['name']}}</label>
                                                        <input id="{{$field}}" name="{{$field}}"
                                                               type='text' class="form-control date"
                                                               value="{{ $resource->$field }}" {{!array_key_exists ('optional', $fieldName) ? 'required' : ''}}/>
                                                    @elseif($fieldName['type'] === 'select')
                                                        <label for="{{$field}}"
                                                               class="require">{{$fieldName['name']}}</label>
                                                        <select class="{{$field}} form-control"
                                                                id="{{key_exists('as', $fieldName) ? $fieldName['as'] : $field}}"
                                                                name="{{$field}}"
                                                                disabled {{!array_key_exists ('optional', $fieldName) ? 'required' : ''}}>
                                                            <option value="{{ $resource->getRouteName() == 'documents' ? $resource->entityRelationship->id : (key_exists('as', $fieldName) ? $resource->{$fieldName['as']} : $resource->$field) }}"
                                                                    selected>{{$resource->getRelatedName($field)}}</option>
                                                            @if(method_exists($resource, 'getSelect') && array_key_exists($field, $resource->getSelect()))
                                                                @foreach($resource->getSelect()[$field] as $key => $value)
                                                                    @if((key_exists('as', $fieldName) ? $resource->{$fieldName['as']} : $resource->$field) != $key && !($resource->getRouteName() == 'documents' && $resource->entityRelationship->id == $key))
                                                                        <option value="{{$key}}">{{$value}}</option>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    @elseif($fieldName['type'] === 'checkbox')
                                                        <label for="{{$field}}"
                                                               class="ts-label">{{$fieldName['name']}}</label>
                                                        <br>
                                                        <div class="toggle-switch" data-ts-color="primary">
                                                            <input id="{{$field}}" name="{{$field}}"
                                                                   type="checkbox"
                                                                   hidden="hidden" {{$resource->$field == 1 ? 'checked' : ''}}>
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
                                                               hidden="hidden" {{$resource->getPivot($fieldName['pivot_name'], $field) ? 'checked' : ''}}>
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
                </form>
            </div>
        </div>

    </div>
    @if($resource->getRouteName() == 'pages')
        <div class="modal fade" id="page-version-modal" tabindex="-1" role="dialog"
             aria-labelledby="page-version-modal-label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div>
                            <div class="form-group">
                                <label for="version">Version:</label>
                                <select class="form-control"
                                        id="version"
                                        name="version">
                                    @foreach($resource->getSelect()['version'] as $key => $value)
                                        <option value="{{$key}}" {{$resource->version == $key ? 'selected' : ''}}>{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick="sendVersion('{{$resource->id}}')">
                                Save
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endif
@endsection