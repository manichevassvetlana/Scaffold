<script src="{{ asset('admin/assets/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/popper.js/popper.min.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/chart.js/chart.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/carbon.js') }}"></script>
<script src="{{ asset('admin/assets/js/demo.js') }}"></script>
<script src="{{ asset('js/bootstrap-notify.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="{{asset('admin/assets/vendor/trumbowyg/dist/trumbowyg.min.js')}}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">

    var routeName = '{{Route::currentRouteName()}}';
    var currentPage = {};
    var pivots = [];
    var abilities = [], abilitiesName, pivotAbilities = $('#pivot-abilities');
    var organizationId = 0, organizationUserId = 0;
    var countySelect = $("#county_id"), addressSelect = $("#address_id"),
        postalCodeSelect = $("#postal_code_id"), citySelect = $("#city_id"),
        stateSelect = $("#state_id"), countrySelect = $("#country_id");
    var userSelect = $('#user_id'), authorSelect = $('#author_id'), apiTypeSelect = $('#type_api'), categoryTypeSelect = $('#type_category'), categorySelect = $('#parent_id'),
        documentCategorySelect = $('#category_id'), referenceTypeSelect = $('#reference_type'), referenceSelect = $('#reference_id'),
        repositoryTypeSelect = $('#type_repository'), SDKTypeSelect = $('#type_sdk'), pageType = $('#type'), pageVersion = $('#version'),
        pageStatus = $('#status'), pageLayout = $('#layout'), organizationSelect = $('#organization_id'), planSelect = $('#plan_id'),
        roleSelect = $('#role_id'), abilitySelect = $('#ability_id');
    var rolesPivotDiv = $('#pivot-roles'), rolesTBody = $('#roles-body'), pivotInput = $('#pivot-input');
    var filterForm = $('#count-form');
    var dependencies = {
        'postal_code_id': [addressSelect],
        'city_id': [postalCodeSelect, addressSelect],
        'state_id': [citySelect, countySelect, postalCodeSelect, addressSelect],
        'country_id': [stateSelect, citySelect, postalCodeSelect, countySelect, addressSelect],
        'type': [pageVersion],
        'organization_id': [roleSelect]
    };
    var undisabled = [countrySelect, apiTypeSelect, categoryTypeSelect, categorySelect,
        referenceTypeSelect, documentCategorySelect, referenceSelect, repositoryTypeSelect, SDKTypeSelect, pageType,
        pageStatus, pageLayout, organizationSelect, planSelect, abilitySelect, authorSelect, $('#organization_role')];

    var pivot = [];
    var currentRoleId = 0;


    $('#editor').trumbowyg();

    function submitEditForm(form){
        if(routeName == 'organization-users.create'){
            swal({
                title: 'Action required',
                text: 'This user already belongs to one of the organizations. Do you want to update information about this user?',
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willUpdate) => {
                    if (willUpdate) {
                        form.submit();
                    } else {
                        swal('The record was not created.');
                        return false;
                    }
                });
        } else form.submit();
        return false;
    }

    $(document).ready(function () {
        if(routeName != 'organization-users.edit') userSelect.removeAttr("disabled");
        for (var i = 0; i < undisabled.length; i++) {
            undisabled[i].removeAttr("disabled");
        }
    });

    function cleanDependencies(id, childNumb) {
        var dep = dependencies[id];
        for (var i = 0; i < dep.length; i++) {
            dep[i].html('<option selected></option>');
            if (i >= childNumb) dep[i].attr('disabled', 'disabled');
            else dep[i].removeAttr("disabled");
        }
    }

    function removeResource(path, id) {
        console.log(path);
        axios.delete(path + '/' + id).then(response => {
            if(response.data == 1) location.reload();
            else if(response.data.status == 0) removeResourceAction(response.data);
            else swal('Delete related records from ' + response.data + ' before you can delete this record.');
        }).catch(e => {
            console.log(e);
        });
    }

    function removeResourceAction(json){
        swal({
            title: 'Action required',
            text: json.message,
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willRemove) => {
                if (willRemove) {
                    axios.delete(json.path).then(response => {
                        location.reload();
                    }).catch(e => {
                        console.log(e);
                    });
                } else {
                    swal('The record was not deleted.');
                }
            });
    }

    /*** Organization - User - Roles start ***/

    /* Modals start */

    $('#pivot-roles-add-modal').on('shown.bs.modal', function (event) {
        let button = $(event.relatedTarget);
        let modal = $(this);
    });

    $('#pivot-roles-edit-modal').on('shown.bs.modal', function (event) {
        let button = $(event.relatedTarget);
        let roleId = button.data('role-id');
        let modal = $(this);

        let td = button.closest('td');
        let tr = td.closest('tr');

        let startDate = button.data('start-date');
        let endDate = button.data('end-date');
        let isRecorded = button.data('recorded');
        let elementId = isRecorded ? button.data('id') : 0;

        let oldValue = {start_date: startDate, end_date: endDate, role_id: "" + roleId};

        (modal.find('#edit-start-date')).val(startDate);
        (modal.find('#edit-end-date')).val(endDate);

        (modal.find('#edit-role-btn-save')).click(function () {
            let newRole = {
                element_id: 'new-record-' + currentRoleId++,
                user_id: '{{strrpos(Route::currentRouteName(), "users") !== false ? $resource->id : ''}}',
                name: modal.find('#edit-role-id option:selected').text(),
                organization_id: '{{strrpos(Route::currentRouteName(), "users") !== false && !is_null($resource->organization()) ? $resource->organization()->id : ''}}',
                role_id: modal.find('#edit-role-id').val(),
                end_date: modal.find('#edit-end-date').val(),
                start_date: modal.find('#edit-start-date').val()
            };

            let dateStart = new Date(newRole.start_date);
            let dateEnd = new Date(newRole.end_date);

            let btnId = '' + button.attr('id');
            if (btnId.indexOf('old-record') + 1) newRole.id = button.attr('id');

            axios.post('/admin/organization-user-roles/validate', newRole).then(response => {
                let answ = validateRole({
                    start_date: newRole.start_date,
                    end_date: newRole.end_date,
                    role_id: "" + newRole.role_id
                }, button.attr('id'));
                if (response.data.status == 1 && answ.status == 1) {
                    editRoleBtnClick(button, tr, oldValue, isRecorded, elementId, newRole);
                    jQuery('#pivot-roles-edit-modal').modal("hide");
                }
                else {
                    if (response.data.status != 1) actionOrgUserRole(response.data);
                    else if (answ.status != 1) actionOrgUserRole(answ);
                }
            }).catch(e => {
                console.log(e);
            });

        });

    });

    /* Modals end */

    function editRoleBtnClick(btn, tr, oldValue, isRecorded, id, newRole) {
        if (isRecorded) {
            axios.put('/admin/organization-user-roles/' + id + '/update', newRole).then(response => {
                updateRole(btn, tr, newRole);
            }).catch(e => {
                console.log(e);
            });
        }
        else {
            let index = getArrayKey(pivot, oldValue);
            if (index > -1) {
                updateRole(btn, tr, newRole);
                setRoleValues(index, newRole);
                pivotInput.val(JSON.stringify(pivot));
            }

        }
    }

    function removeBtnClick(id, isRemovable, button) {
        let td = button.closest('td');
        let tr = td.closest('tr');

        console.log(button);
        console.log(td);
        console.log(tr);

        if(isRemovable){
            axios.post('/admin/organization-user-roles/' + id, {user_id: '{{strrpos(Route::currentRouteName(), "users") !== false ? $resource->id : 'lol'}}'}).then(response => {
                tr.remove();
                swal('The record was deleted.');
            }).catch(e => {
                console.log(e);
            });
        }
        else{
            pivot.splice(getArrayKeyById(pivot, 'element_id', id), 1);
            pivotInput.val(JSON.stringify(pivot));
            tr.remove();
        }
    }

    function setRoleValues(pivotIndex, newRole) {
        pivot[pivotIndex].role_id = newRole.role_id;
        pivot[pivotIndex].start_date = newRole.start_date;
        pivot[pivotIndex].end_date = newRole.end_date;
    }

    function updateRole(btn, tr, newRole) {
        btn.attr('data-role-id', newRole.role_id);
        btn.attr('data-start-date', newRole.start_date);
        btn.attr('data-end-date', newRole.end_date);

        tr.find('td').eq(0).text(newRole.name);
        tr.find('td').eq(1).text(newRole.start_date);
        tr.find('td').eq(2).text(newRole.end_date);
    }


    function addOrganizationUserRole(element) {
        pivot.push({
            start_date: element.start_date,
            end_date: element.end_date,
            role_id: element.role_id,
            element_id: element.element_id
        });
        var html = '<tr><td>' + element.role_name + '</td><td>' + element.start_date + '</td><td>' + element.end_date + '</td>' +
            '<td><button type="button" class="btn btn-warning"' +
            'data-toggle="modal" data-target="#pivot-roles-edit-modal" ' +
            'data-role-id="' + element.role_id + '" data-start-date="' + element.start_date + '" ' +
            'data-end-date="' + element.end_date + '" data-recorded="false" id="' + element.element_id + '">Edit</button></td><td><a class="btn btn-danger remove-role" onclick="removeBtnClick(`' + element.element_id + '`, false, this)">Remove</a></td></tr>';
        rolesTBody.append(html);
        pivotInput.val(JSON.stringify(pivot));
    }

    organizationSelect.change(function () {
        $('#add-pivot-btn').removeAttr("disabled");
        cleanDependencies(this.id, 1);
    });

    function addRoleBtnClick() {
        let roleSelect = $('#role-id');
        let role = {
            element_id: 'new-record-' + currentRoleId++,
            organization_id: '{{strrpos(Route::currentRouteName(), "users") !== false  && !is_null($resource->organization()) ? $resource->organization()->id : ''}}',
            role_id: roleSelect.val(),
            user_id: '{{strrpos(Route::currentRouteName(), "users") !== false ? $resource->id : ''}}',
            role_name: roleSelect.find(":selected").text(),
            start_date: $('#start-date').val(),
            end_date: $('#end-date').val()
        };
        let dateStart = new Date(role.start_date);
        let dateEnd = new Date(role.end_date);
        axios.post('/admin/organization-user-roles/validate', role).then(response => {
            let answ = validateRole({start_date: role.start_date, end_date: role.end_date, role_id: "" + role.role_id});
            if (response.data.status == 1 && answ.status == 1) {
                addOrganizationUserRole(role);
                jQuery('#pivot-roles-add-modal').modal("hide");
                swal("Good job!", response.data.message, "success");
            }
            else {
                if (response.data.status != 1) actionOrgUserRole(response.data);
                else if (answ.status != 1) actionOrgUserRole(answ);
            }
        }).catch(e => {
            console.log(e);
        });
    }

    function getArrayKeyById(array, idName, id){
        let i = array.length;
        while (i--) {
            if (array[i][idName] == id) {
                return i;
            }
        }
        return -1;
    }

    function validateRole(role, id = null) {
        let roles = whereExists(pivot, {field: 'role_id', value: role.role_id});
        if (roles !== -1) {
            console.log('Roles before:');
            console.log(roles);
            console.log('----------------------');
            if(id !== null && getArrayKeyById(roles, 'element_id', id) != -1) {
                roles.splice(getArrayKeyById(roles, 'element_id', id), 1);
                console.log('lol');
                console.log(roles);
                console.log('----------------------');
            }
            console.log('----------------------');
            console.log('Roles after:');
            console.log(roles);
            console.log('----------------------');
            console.log(id);
            console.log(getArrayKeyById(roles, 'element_id', id));
            if (getArrayKey(roles, role) != -1) return getOrgUserRoleValidationCode(0);
            let dateStartNewEntry = new Date(role.start_date);
            let dateEndNewEntry = role.end_date === '' ? null : new Date(role.end_date);
            if (dateEndNewEntry !== null && dateStartNewEntry > dateEndNewEntry) return getOrgUserRoleValidationCode(0);
            let dateNow = new Date();
            let i = roles.length;
            while (i--) {
                let code = null;
                let element_id = null;
                let dateStart = new Date(roles[i].start_date);
                let dateEnd = roles[i].end_date == '' ? null : new Date(roles[i].end_date);
                if (role.end_date !== '') {
                    if (dateStartNewEntry < dateEnd || dateEnd === null) {
                        if (dateStart == dateStartNewEntry || dateStartNewEntry > dateStart) return getOrgUserRoleValidationCode(dateEnd === null ? -1 : -2, roles[i].element_id);
                        if (dateStart < dateEndNewEntry) return getOrgUserRoleValidationCode(-3, roles[i].element_id);
                    }
                } else {
                    if (dateEnd !== null) {
                        if ((dateStart < dateStartNewEntry && dateEnd > dateStartNewEntry) || (dateStart >= dateStartNewEntry)) return getOrgUserRoleValidationCode(-4, roles[i].element_id);
                    }
                    else {
                        if (dateStartNewEntry < dateStart) return getOrgUserRoleValidationCode(-5, roles[i].element_id);
                        if (dateStartNewEntry > dateStart) return getOrgUserRoleValidationCode(-6, roles[i].element_id);
                    }
                }
            }
        }
        return getOrgUserRoleValidationCode(1);
    }


    function getArrayKey(array, search) {
        let i = array.length;
        while (i--) {
            if (array[i].role_id == search.role_id && array[i].start_date == search.start_date && array[i].end_date == search.end_date) {
                return i;
            }
        }
        return -1;
    }

    function whereExists(array, search) {
        let i = array.length;
        let appropriate = [];
        while (i--) {
            if (array[i][search.field] == search.value) {
                appropriate.push(array[i]);
            }
        }
        return appropriate.length > 0 ? appropriate : -1;
    }

    function getOrgUserRoleValidationCode(code, id = null) {
        switch (code) {
            case 1:
                return {status: 1, message: 'Record was created successfully.'};
                break;
            case 0:
                return {
                    status: 0,
                    message: 'Record is not unique.',
                    solution: 'You need to set correct data for a new record.',
                    action: 1
                };
                break;
            case -1:
                return {
                    id: id,
                    status: 0,
                    message: 'The new record overlaps the old one.',
                    solution: 'Do you want to edit the old record?',
                    action: 2
                };
                break;
            case -2:
                return {
                    id: id,
                    status: 0,
                    message: 'The old record for the same role has null end date.',
                    solution: 'Do you want to edit the old record?',
                    action: 2
                };
                break;
            case -3:
                return {
                    status: 0,
                    message: 'The new record overlaps the old one.',
                    solution: 'You need to set end date for the new record before start date for the new one.',
                    action: 1
                };
                break;
            case -4:
            case -5:
            case -6:
                return {
                    id: id,
                    status: 0,
                    message: 'There exists the record for this role for these dates.',
                    solution: 'Do you want to edit the old record?',
                    action: 2
                };
                break;
        }
        return {
            status: 0,
            message: 'Something went wrong. Try again.',
            solution: 'You need to set correct data for a new record.',
            action: 1
        };
    }

    function actionOrgUserRole(json) {
        if (json.action === 2) {
            swal({
                title: json.message,
                text: json.solution,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willChange) => {
                    if (willChange) {
                        let elId = "" + json.id;
                        console.log(elId);
                        console.log(elId.indexOf('new-record') + 1);
                        (elId.indexOf('new-record') + 1) ? document.getElementById(elId).click() : document.getElementById('old-record-' + elId).click();
                    } else {
                        swal("Ok");
                    }
                });
        }
        else if (json.action === 1) swal(json.message, json.solution, "warning");

    }

    /*** Organization - User - Roles end ***/


    // Set options for state select
    countrySelect.change(function () {
        cleanDependencies(this.id, 1);
    });

    // Set options for city select
    stateSelect.change(function () {
        cleanDependencies(this.id, 2);
    });

    // Set options for postal code select
    $(citySelect, apiTypeSelect).change(function () {
        cleanDependencies(this.id, 1);
    });

    // Set options for address select
    postalCodeSelect.change(function () {
        cleanDependencies(this.id, 1);
    });


    roleSelect.select2({
        placeholder: 'Choose role...',
        ajax: {
            url: function () {
                return '/admin/organization-role-abilities/' + organizationSelect.val()
            },
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });

    abilitySelect.select2({
        placeholder: 'Choose ability...',
        ajax: {
            url: function () {
                return '/admin/abilities/find'
            },
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });

    // Select2 for address select
    countySelect.select2({
        placeholder: 'Choose county...',
        ajax: {
            url: function () {
                return '/admin/counties/' + stateSelect.val()
            },
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });

    // Select2 for address select
    addressSelect.select2({
        placeholder: 'Choose address...',
        ajax: {
            url: function () {
                return '/admin/addresses/' + postalCodeSelect.val()
            },
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.line_1,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });

    // Select2 for city select
    citySelect.select2({
        placeholder: 'Choose city...',
        ajax: {
            url: function () {
                return '/admin/cities/' + stateSelect.val()
            },
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });

    // Select2 for state select
    stateSelect.select2({
        placeholder: 'Choose state...',
        ajax: {
            url: function () {
                return '/admin/states/' + countrySelect.val()
            },
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });

    // Select2 for organization select
    organizationSelect.select2({
        placeholder: 'Choose organization...',
        ajax: {
            url: function () {
                return '/admin/organizations/find'
            },
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });

    // Select2 for state select
    postalCodeSelect.select2({
        placeholder: 'Choose postal code...',
        ajax: {
            url: function () {
                return '/admin/postal-codes/' + citySelect.val()
            },
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.postal_code,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });

    // Select2 for country select; search countries by name via ajax
    countrySelect.select2({
        placeholder: 'Choose country...',
        ajax: {
            url: '/admin/countries/find',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });

    $(userSelect, authorSelect).select2({
        placeholder: 'Choose user...',
        ajax: {
            url: '/admin/users/find',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.name + ' - ' + item.email,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });

    categorySelect.select2({
        placeholder: 'Choose category...',
        ajax: {
            url: '/admin/categories/find',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });

    categoryTypeSelect.select2({
        placeholder: 'Choose category type...',
        ajax: {
            url: '/admin/categories/types',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.value,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });

    apiTypeSelect.select2({
        placeholder: 'Choose API type...',
        ajax: {
            url: '/admin/apis/find',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.value,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });

    // Go to another page
    $('.paginate_button').click(function () {
        //$('#page-counter').val(this.innerHTML);
        filterForm.submit();
    });

    $('#search-resource').keypress(function (e) {
        if (e.which == 13) {
            if (this.value.length >= 2) {
                filterForm.append('<input name="search" value="' + this.value + '" style="display:none">');
                filterForm.submit();
            }
        }
    });

    $('#count-resources').change(function (e) {
        $('#page-counter').val('1');
        filterForm.submit();
    });

    $('#file-input').change(function (event) {
        var reader = new FileReader();
        reader.onload = function () {
            var output = document.getElementById('user-img');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    });

    pageType.change(function (e) {
        cleanDependencies(this.id, 1);

        var page = $("#type option:selected").text();
        var versions = [];

        pageVersion.html('');
        if (page == 'main') versions = [{id: 1, name: 1}];
        $.each(versions, function (index, element) {
            pageVersion.append("<option value='" + element.id + "'>" + element.name + "</option>");
        });
    });

    function announcementShow(body, link, link_text, id) {
        $.notify({
            // options
            icon: '',
            title: '',
            message: body,
            url: link,
            target: '_blank'
        }, {
            // settings
            element: 'body',
            position: null,
            type: "info",
            allow_dismiss: true,
            newest_on_top: false,
            showProgressbar: false,
            placement: {
                from: "bottom",
                align: "right"
            },
            offset: 20,
            spacing: 10,
            z_index: 1031,
            delay: Infinity,
            timer: 1000,
            url_target: '_blank',
            mouse_over: null,
            animate: {
                enter: 'animated fadeInDown',
                exit: 'animated fadeOutUp'
            },
            onShow: null,
            onShown: null,
            onClose: null,
            onClosed: null,
            icon_type: 'class',
            template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-announcement" role="alert">' +
            '<button type="button" aria-hidden="true" class="close" data-notify="dismiss" onclick="readAnnouncement(`' + id + '`)">×</button>' +
            '<span data-notify="title">{1}</span> ' +
            '<span data-notify="message">{2}</span>' +
            '<a href="/announcement/' + id + '" target="{4}" data-notify="url"></a>' +
            '</div>'
        });
    }

    function readAnnouncement(id) {
        axios.put('/announcements/' + id + '/read').then(response => {
        }).catch(e => {
            console.log(e);
        });
    }

    function sendInvitation() {
        $('#loader-owner-invite').css({"display": ''});
        $('#btn-owner-invite').css({"display": 'none'});
        axios.post('/mail/invitation', {receiver: document.getElementById('email-owner').value}).then(response => {
            $('#loader-owner-invite').css({"display": 'none'});
            $('#btn-owner-invite').css({"display": ''});
            alert('Success');
        }).catch(e => {
            alert('Invitation was not sent');
            console.log(e);
        });
    }

    $('#leave-company').click(function () {
        axios.put('/organization/leave').then(response => {
            $('#org-section').html('');
        }).catch(e => {
            console.log(e);
        });
    });

    $('#page-version-modal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var modal = $(this);
    });

    function sendVersion(id) {
        axios.put('/admin/pages/' + id + '/version', {version: document.getElementById('version').value}).then(response => {
            window.location = '/admin/pages/' + id + '/edit';
        }).catch(e => {
            console.log(e);
        });
    }

</script>
<script>
    $(document).ready(function () {
        $('#reference_type').on('change', function () {
            var referenceType = $(this).val();

            if (referenceType != 0) {

                $.ajax({
                    url: '/admin/documents/' + referenceType,
                    type: 'GET',
                    dataType: 'json',
                    beforeSend: function () {
                        $('#loader').css('visibility', 'visible');
                    },
                    success: function (data) {
                        var reference = referenceSelect;
                        var nameField = data.field;
                        reference.empty();
                        $.each(data.references, function (index, element) {
                            reference.append("<option value='" + element.id + "'>" + element[nameField] + "</option>");
                        });
                    },
                    complete: function () {
                        $('#loader').css('visibility', 'hidden');
                    }
                });
            } else {
                referenceSelect.html('');
            }
        });
    });
</script>
<script>
    $('.date').datepicker({
        format: 'yyyy-mm-dd',
        orientation: 'bottom'
    });
</script>
<script>
    function getCountryId(latlng) {

        latlng = new google.maps.LatLng(latlng.lat, latlng.lng);
        new google.maps.Geocoder().geocode({'latLng': latlng}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[1]) {
                    var country = null, countryCode = null, city = null, cityAlt = null;
                    var c, lc, component;
                    for (var r = 0, rl = results.length; r < rl; r += 1) {
                        var result = results[r];

                        if (!city && result.types[0] === 'locality') {
                            for (c = 0, lc = result.address_components.length; c < lc; c += 1) {
                                component = result.address_components[c];

                                if (component.types[0] === 'locality') {
                                    city = component.long_name;
                                    break;
                                }
                            }
                        }
                        else if (!city && !cityAlt && result.types[0] === 'administrative_area_level_1') {
                            for (c = 0, lc = result.address_components.length; c < lc; c += 1) {
                                component = result.address_components[c];

                                if (component.types[0] === 'administrative_area_level_1') {
                                    cityAlt = component.long_name;
                                    break;
                                }
                            }
                        } else if (!country && result.types[0] === 'country') {
                            country = result.address_components[0].long_name;
                            countryCode = result.address_components[0].short_name;
                        }

                        if (city && country) {
                            break;
                        }
                    }

                    axios.get('/admin/code-county/' + countryCode).then(function (response) {
                        countries = response.data;
                        if (countries.length > 0) {
                            countrySelect.html('<option selected value="' + countries[0].id + '">' + countries[0].name + '</option>');
                        }
                    }).catch(function (error) {
                        console.log(error);
                    });
                }
            }
        });
    }
</script>