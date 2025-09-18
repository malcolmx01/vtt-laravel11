@extends('vtt.layouts.main')
@section('page','Employee Profile')
@section('description','Employee profile archive')
@section('header-component')
    <a href="#" class="btn kt-subheader__btn-primary">
        Actions &nbsp;
        <i class="flaticon2-calendar-1"></i>
    </a>
@endsection

@section('content')
    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        <!-- begin:: Content Head -->
        <div class="kt-subheader   kt-grid__item" id="kt_subheader">
            <div class="kt-container  kt-container--fluid ">
                <div class="kt-subheader__main">
                    <h3 class="kt-subheader__title">
                        Employee Profile Archive
                    </h3>
                    <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                    <div class="kt-subheader__group" id="kt_subheader_search">
										<span class="kt-subheader__desc" id="kt_subheader_total">
											Total </span>
                        <form class="kt-margin-l-20" id="kt_subheader_search_form">
                            <div class="kt-input-icon kt-input-icon--right kt-subheader__search">
                                <input type="text" class="form-control" placeholder="Search..." id="generalSearch">
                                <span class="kt-input-icon__icon kt-input-icon__icon--right">
													<span>
														<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
															<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																<rect x="0" y="0" width="24" height="24" />
																<path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
																<path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero" />
															</g>
														</svg>
													</span>
												</span>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="kt-subheader__toolbar">
                    <a href="/employees/create" class="btn btn-brand btn-elevate btn-icon-sm">
                        <i class="la la-plus"></i>
                        Add
                    </a>
                    <div class="kt-subheader__wrapper">
                        <div class="dropdown dropdown-inline" data-toggle="kt-tooltip-" title="Quick actions" data-placement="left">
                            <a href="#" class="btn btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon kt-svg-icon--success kt-svg-icon--md">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <polygon points="0 0 24 0 24 24 0 24" />
                                        <path d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                        <path d="M11,14 L9,14 C8.44771525,14 8,13.5522847 8,13 C8,12.4477153 8.44771525,12 9,12 L11,12 L11,10 C11,9.44771525 11.4477153,9 12,9 C12.5522847,9 13,9.44771525 13,10 L13,12 L15,12 C15.5522847,12 16,12.4477153 16,13 C16,13.5522847 15.5522847,14 15,14 L13,14 L13,16 C13,16.5522847 12.5522847,17 12,17 C11.4477153,17 11,16.5522847 11,16 L11,14 Z" fill="#000000" />
                                    </g>
                                </svg>

                                <!--<i class="flaticon2-plus"></i>-->
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- end:: Content Head -->

        <input id="id" value={{$store_id}} type="hidden">

        <!-- end:: Content Head -->
    </div>

    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    Details
                </h3>
            </div>
        </div>
        <div class="kt-portlet__body kt-portlet__body--fit">
            <!--begin: Datatable -->
            <div id = "my_table">
                <div class="kt-datatable" id="kt_apps_employees_list_datatable"></div>
            </div>
            <!--end: Datatable -->
        </div>
    </div>

@endsection

@section('modal')
    <!-- Delete Model -->
    <form action="" method="POST" class="remove-record-model">
        <div id="custom-width-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" >
            <div class="modal-dialog" style="width:55%;">
                <div class="modal-content square shadow">
                    <div class="modal-header">
                        <h5 class="modal-title" id="custom-width-modalLabel">Confirmation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <div>
                            <p>
                                Are you sure, you want to permanently delete employee No. :<strong style="font-weight: bold; font-size: 20px;" class="post-record-id">.</strong><br/><br/>
                                employee: <strong style="font-weight: bold; font-size: 20px;" class="post-record-title"></strong>?
                            </p>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-danger waves-effect waves-light"><span class="lnr-trash2"></span> Delete</button>
                        <button type="button" class="btn btn-sm btn-default waves-effect remove-data-from-delete-form" data-dismiss="modal"><span class="lnr-cross-circle"></span> Close</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('scripts')

    <script>

        $(document).ready(function() {

            $('.js-basic-single').select2();


            refresh_list();
        });

        function formatDate(date_param) {
            if(!isNaN(date_param)) {
                return '';
            } else {
                return new Date(date_param).toLocaleDateString('en-US');
            }
        }

        function refresh_list() {

            $("#my_table").html('');
            $("#my_table").append('<div class="kt-datatable" id="kt_apps_employees_list_datatable"></div>');

            "use strict";
            // Class definition

            var KTJevHdrsListDatatable = function() {

                // variables
                var datatable;

                // init
                var init = function() {

                    datatable = $('#kt_apps_employees_list_datatable').KTDatatable({
                        // datasource definition
                        data: {
                            type: 'remote',
                            source: {
                                read: {
                                    url: '/EmployeeList',
                                    method: 'get',
                                    contentType: 'application/json',
                                },
                            },
                            pageSize: 10, // display 20 records per page
                            serverPaging: false,
                            serverFiltering: false,
                            serverSorting: false,
                        },

                        // layout definition
                        layout: {
                            scroll: true, // enable/disable datatable scroll both horizontal and vertical when needed.
                            footer: false, // display/hide footer
                        },

                        // column sorting
                        sortable: true,

                        pagination: true,

                        search: {
                            input: $('#generalSearch'),
                            delay: 400,
                        },

                        // columns definition
                        columns: [{
                            width: 50,
                            field: 'id',
                            title: 'Record ID',
                            textAlign: 'left',
                        }, {
                            field: "name",
                            title: "Employee",
                            width: 250,
                            autoHide: false,
                            // callback function support for column rendering
                            template: function(data, i) {
                                var output = '<div class="kt-user-card-v2 kt-user-card-v2--uncircle">\
                                        <div class="kt-user-card-v2__pic">\
                                            <img src="{{ url('/') }}/storage/employee_image/' + data.avatar + '" alt="photo">\
                                        </div>\
                                        <div class="kt-user-card-v2__details">\
                                            <a href="#" class="kt-user-card-v2__name">' + data.name + '</a>\
                                        </div>\
                                    </div>';

                                return output;
                            }
                        }, {
                            field: "contact_nos",
                            title: "Contact Info",
                            width: 150,
                            autoHide: false,
                            // callback function support for column rendering
                            template: function (data) {
                                var output = '\
                                <div class="kt-user-card-v2__details">\
                                    <span class="kt-user-card-v2__name">' + data.contact_nos +'</span>\
                                </div>\
                                <div class="kt-user-card-v2__details">\
                                    <span class="kt-user-card-v2__email">' + data.email + '</span>\
                                </div>';
                                return output;
                            }
                        }, {
                            field: "store_id",
                            title: "Company",
                            width: 150,
                            autoHide: false,
                            // callback function support for column rendering
                            template: function (data) {
                                var output = '\
                                <div class="kt-user-card-v2__details">\
                                    <a span class="kt-user-card-v2__name">' + data.company +'</a>\
                                </div>';
                                return output;
                            }
                        }, {
                            field: "status",
                            title: "Status",
                            width: 100,
                            // callback function support for column rendering
                            template: function(row) {
                                var status = {
                                    '3': {
                                        'title': 'Pending',
                                        'class': ' btn-label-warning'
                                    },
                                    '1': {
                                        'title': 'Active',
                                        'class': ' btn-label-success'
                                    },
                                    '0': {
                                        'title': 'For Activation',
                                        'class': ' btn-label-danger'
                                    }
                                };
                                return '<span class="btn btn-bold btn-sm btn-font-sm ' + status[row.status].class + '">' + status[row.status].title + '</span>';
                            }
                        }, {
                            field: "Actions",
                            width: 80,
                            title: "Actions",
                            textAlign: 'center',
                            sortable: false,
                            autoHide: false,
                            overflow: 'visible',
                            template: function(data) {
                                var record_id  = data.id ;
                                var show_route = "{{ route('employees.show', ':id')}}";
                                var edit_route = "{{ route('employees.edit', ':id')}}";
                                var delete_route = "{{ route('employees.destroy', ':id')}}";
                                var load_route = "/pos/C" + data.id;
                                var output = "";

                                show_route = show_route.replace(':id',record_id);
                                edit_route = edit_route.replace(':id',record_id);
                                delete_route = delete_route.replace(':id',record_id);

                                if (data.status >= 4) {
                                    output =  '<div class="dropdown">\
                                        <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown">\
                                            <i class="flaticon-more-1"></i>\
                                        </a>\
                                        <div class="dropdown-menu dropdown-menu-right">\
                                            <ul class="kt-nav">\
                                                <li class="kt-nav__item">\
                                                    <a href=' + show_route + ' class="kt-nav__link">\
                                                        <i class="kt-nav__link-icon flaticon2-expand"></i>\
                                                        <span class="kt-nav__link-text">View</span>\
                                                    </a>\
                                                </li>\
                                            </ul>\
                                        </div>\
                                    </div>';
                                } else {
                                    output =
                                    '<div class="dropdown">\
                                        <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown">\
                                            <i class="flaticon-more-1"></i>\
                                        </a>\
                                        <div class="dropdown-menu dropdown-menu-right">\
                                            <ul class="kt-nav">\
                                                <li class="kt-nav__item">\
                                                    <a href=' + show_route + ' class="kt-nav__link">\
                                                        <i class="kt-nav__link-icon flaticon2-expand"></i>\
                                                        <span class="kt-nav__link-text">View</span>\
                                                    </a>\
                                                </li>\
                                                <li class="kt-nav__item">\
                                                    <a href=' + edit_route + ' class="kt-nav__link">\
                                                        <i class="kt-nav__link-icon flaticon2-contract"></i>\
                                                        <span class="kt-nav__link-text">Edit</span>\
                                                    </a>\
                                                </li>\
                                                <li class="kt-nav__item">\
                                                    <a title="Delete" href="" class="kt-nav__link" id="remove-record"' +
                                                        'data-toggle="modal"' +
                                                        'data-url="' + delete_route + '"' +
                                                        'data-id="' + data.id + '"' +
                                                        'data-title="' + data.name + '"' +
                                                        'data-type="Item"' +
                                                        'data-target="#custom-width-modal">\
                                                        <i class="kt-nav__link-icon flaticon2-trash"></i>\
                                                        <span class="kt-nav__link-text">Delete</span>\
                                                    </a>\
                                                </li>\
                                            </ul>\
                                        </div>\
                                    </div>';
                                }
                                return output;
                            },
                        }]
                    });
                }



                // search
                var search = function() {
                    $('#kt_form_status').on('change', function() {
                        datatable.search($(this).val().toLowerCase(), 'Status');
                    });
                }

                // selection
                var selection = function() {
                    // init form controls
                    $('#kt_form_status, #kt_form_type').selectpicker();

                    // event handler on check and uncheck on records
                    datatable.on('kt-datatable--on-check kt-datatable--on-uncheck kt-datatable--on-layout-updated',	function(e) {
                        var checkedNodes = datatable.rows('.kt-datatable__row--active').nodes(); // get selected records
                        var count = checkedNodes.length; // selected records count

                        $('#kt_subheader_group_selected_rows').html(count);

                        if (count > 0) {
                            $('#kt_subheader_search').addClass('kt-hidden');
                            $('#kt_subheader_group_actions').removeClass('kt-hidden');
                        } else {
                            $('#kt_subheader_search').removeClass('kt-hidden');
                            $('#kt_subheader_group_actions').addClass('kt-hidden');
                        }
                    });
                }

                // fetch selected records
                var selectedFetch = function() {
                    // event handler on selected records fetch modal launch
                    $('#kt_datatable_records_fetch_modal').on('show.bs.modal', function(e) {
                        // show loading dialog
                        var loading = new KTDialog({'type': 'loader', 'placement': 'top center', 'message': 'Loading ...'});
                        loading.show();

                        setTimeout(function() {
                            loading.hide();
                        }, 1000);

                        // fetch selected IDs
                        var ids = datatable.rows('.kt-datatable__row--active').nodes().find('.kt-checkbox--single > [type="checkbox"]').map(function(i, chk) {
                            return $(chk).val();
                        });

                        // populate selected IDs
                        var c = document.createDocumentFragment();

                        for (var i = 0; i < ids.length; i++) {
                            var li = document.createElement('li');
                            li.setAttribute('data-id', ids[i]);
                            li.innerHTML = 'Selected record ID: ' + ids[i];
                            c.appendChild(li);
                        }

                        $(e.target).find('#kt_apps_user_fetch_records_selected').append(c);
                    }).on('hide.bs.modal', function(e) {
                        $(e.target).find('#kt_apps_user_fetch_records_selected').empty();
                    });
                };

                // selected records status update
                var selectedStatusUpdate = function() {
                    $('#kt_subheader_group_actions_status_change').on('click', "[data-toggle='status-change']", function() {
                        var status = $(this).find(".kt-nav__link-text").html();

                        // fetch selected IDs
                        var ids = datatable.rows('.kt-datatable__row--active').nodes().find('.kt-checkbox--single > [type="checkbox"]').map(function(i, chk) {
                            return $(chk).val();
                        });

                        if (ids.length > 0) {
                            // learn more: https://sweetalert2.github.io/
                            swal.fire({
                                buttonsStyling: false,

                                html: "Are you sure to update " + ids.length + " selected records status to " + status + " ?",
                                type: "info",

                                confirmButtonText: "Yes, update!",
                                confirmButtonClass: "btn btn-sm btn-bold btn-brand",

                                showCancelButton: true,
                                cancelButtonText: "No, cancel",
                                cancelButtonClass: "btn btn-sm btn-bold btn-default"
                            }).then(function(result) {
                                if (result.value) {
                                    swal.fire({
                                        title: 'Deleted!',
                                        text: 'Your selected records statuses have been updated!',
                                        type: 'success',
                                        buttonsStyling: false,
                                        confirmButtonText: "OK",
                                        confirmButtonClass: "btn btn-sm btn-bold btn-brand",
                                    })
                                    // result.dismiss can be 'cancel', 'overlay',
                                    // 'close', and 'timer'
                                } else if (result.dismiss === 'cancel') {
                                    swal.fire({
                                        title: 'Cancelled',
                                        text: 'You selected records statuses have not been updated!',
                                        type: 'error',
                                        buttonsStyling: false,
                                        confirmButtonText: "OK",
                                        confirmButtonClass: "btn btn-sm btn-bold btn-brand",
                                    });
                                }
                            });
                        }
                    });
                }

                // selected records delete
                var selectedDelete = function() {
                    $('#kt_subheader_group_actions_delete_all').on('click', function() {
                        // fetch selected IDs
                        var ids = datatable.rows('.kt-datatable__row--active').nodes().find('.kt-checkbox--single > [type="checkbox"]').map(function(i, chk) {
                            return $(chk).val();
                        });

                        if (ids.length > 0) {
                            // learn more: https://sweetalert2.github.io/
                            swal.fire({
                                buttonsStyling: false,

                                text: "Are you sure to delete " + ids.length + " selected records ?",
                                type: "danger",

                                confirmButtonText: "Yes, delete!",
                                confirmButtonClass: "btn btn-sm btn-bold btn-danger",

                                showCancelButton: true,
                                cancelButtonText: "No, cancel",
                                cancelButtonClass: "btn btn-sm btn-bold btn-brand"
                            }).then(function(result) {
                                if (result.value) {
                                    swal.fire({
                                        title: 'Deleted!',
                                        text: 'Your selected records have been deleted! :(',
                                        type: 'success',
                                        buttonsStyling: false,
                                        confirmButtonText: "OK",
                                        confirmButtonClass: "btn btn-sm btn-bold btn-brand",
                                    })
                                    // result.dismiss can be 'cancel', 'overlay',
                                    // 'close', and 'timer'
                                } else if (result.dismiss === 'cancel') {
                                    swal.fire({
                                        title: 'Cancelled',
                                        text: 'You selected records have not been deleted! :)',
                                        type: 'error',
                                        buttonsStyling: false,
                                        confirmButtonText: "OK",
                                        confirmButtonClass: "btn btn-sm btn-bold btn-brand",
                                    });
                                }
                            });
                        }
                    });
                }

                var updateTotal = function() {

                    datatable.on('kt-datatable--on-layout-updated', function () {
                        $('#kt_subheader_total').html(datatable.getTotalRows() + ' Total');
                    });

                };

                return {

                    // public functions
                    init: function() {
                        init();
                        search();
                        selection();
                        selectedFetch();
                        selectedStatusUpdate();
                        selectedDelete();
                        updateTotal();
                    },
                };
            }();

            // On document ready
            KTUtil.ready(function() {
                KTJevHdrsListDatatable.init();
            });

        };

        $(document).on('click', '#remove-record', function() {
            var id = $(this).attr('data-id');
            var url = $(this).attr('data-url');
            var title = $(this).attr('data-title');
            var type = $(this).attr('data-type');
            var token = $('meta[name="csrf-token"]').attr('content');

            $(".remove-record-model").attr("action", url);
            // console.log('ber---'+$(".remove-record-model").attr("action",url));
            $('body').find('.post-record-id').text(id);
            $('body').find('.post-record-type').text(type);
            $('body').find('.post-record-title').text(title);

            $('body').find('.remove-record-model').append('<input name="_token" type="hidden" value="' + token + '">');
            $('body').find('.remove-record-model').append('<input name="_method" type="hidden" value="delete">');
            $('body').find('.remove-record-model').append('<input name="id" type="hidden" value="' + id + '">');
        });

    </script>
@endsection
