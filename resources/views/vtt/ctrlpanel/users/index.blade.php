@extends('vtt.layouts.main')
@section('page','Users')
@section('description','Users archive')
@section('styles')
    <style type="text/css">
        #myScrollBottomBtn {
            ßposition: fixed;
            bottom: 20px;
            right: 30px;
            z-index: 99;
            font-size: 20px;
            border: none;
            outline: none;
            background-color: rgba(11, 56, 230, 0.25);
            color: white;
            cursor: pointer;
            padding: 0px 10px 0px 10px;
            border-radius: 4px;
            margin-left: 3px;
        }

        #myScrollBottomBtn:hover {
            background-color: rgba(29, 101, 255, 0.89);
        }

    </style>
@endsection
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
                        User Archive
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
                    <div class="kt-subheader__group kt-hidden" id="kt_subheader_group_actions">
                        <div class="kt-subheader__desc"><span id="kt_subheader_group_selected_rows"></span> Selected:</div>
                        <div class="btn-toolbar kt-margin-l-20">
                            <div class="dropdown" id="kt_subheader_group_actions_status_change">
                                <button type="button" class="btn btn-label-brand btn-bold btn-sm dropdown-toggle" data-toggle="dropdown">
                                    Update Status
                                </button>
                                <div class="dropdown-menu">
                                    <ul class="kt-nav">
                                        <li class="kt-nav__section kt-nav__section--first">
                                            <span class="kt-nav__section-text">Change status to:</span>
                                        </li>
                                        <li class="kt-nav__item">
                                            <a href="#" class="kt-nav__link" data-toggle="status-change" data-status="1">
                                                <span class="kt-nav__link-text"><span class="kt-badge kt-badge--unified-success kt-badge--inline kt-badge--bold">Approved</span></span>
                                            </a>
                                        </li>
                                        <li class="kt-nav__item">
                                            <a href="#" class="kt-nav__link" data-toggle="status-change" data-status="2">
                                                <span class="kt-nav__link-text"><span class="kt-badge kt-badge--unified-danger kt-badge--inline kt-badge--bold">Cancelled</span></span>
                                            </a>
                                        </li>
                                        <li class="kt-nav__item">
                                            <a href="#" class="kt-nav__link" data-toggle="status-change" data-status="3">
                                                <span class="kt-nav__link-text"><span class="kt-badge kt-badge--unified-warning kt-badge--inline kt-badge--bold">Pending</span></span>
                                            </a>
                                        </li>
                                        <li class="kt-nav__item">
                                            <a href="#" class="kt-nav__link" data-toggle="status-change" data-status="4">
                                                <span class="kt-nav__link-text"><span class="kt-badge kt-badge--unified-info kt-badge--inline kt-badge--bold">On Hold</span></span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <button class="btn btn-label-success btn-bold btn-sm btn-icon-h" id="kt_subheader_group_actions_fetch" data-toggle="modal" data-target="#kt_datatable_records_fetch_modal">
                                Fetch Selected
                            </button>
                            <button class="btn btn-label-danger btn-bold btn-sm btn-icon-h" id="kt_subheader_group_actions_delete_all">
                                Delete All
                            </button>
                        </div>
                    </div>
                </div>
                <div class="kt-subheader__toolbar">
                    <a href="{{route('users.create')}}" class="btn btn-brand btn-elevate btn-icon-sm">
                        <i class="la la-plus"></i>
                        Add
                    </a>

                    <a href="#" id="show_tools" class="btn btn-label-danger btn-elevate btn-icon-sm" onclick="initializeTools()"><i class="la la-cog"></i>
                        Show Tools
                    </a>

                    <button onclick="scrollDown()" id="myScrollBottomBtn" title="Go to bottom"><b><i class="fa fa-arrow-down"></i></b></button>

                </div>
            </div>
        </div>
        <!-- end:: Content Head -->

        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
            <!--begin::Portlet-->
            <div class="kt-portlet kt-portlet--mobile">
                <div id = "my_table">
                    <div class="kt-datatable" id="kt_apps_user_list_datatable"></div>
                </div>
            </div>
            <!--end::Portlet-->
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
                                Are you sure, you want to permanently delete the
                                <span class="post-record-type"></span>: <br/>
                                <strong class="post-record-title">.</strong><br/>
                                with ID No: <strong class="post-record-id"></strong>?

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
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js" defer ></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js" defer ></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"defer ></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js" defer ></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"defer ></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js" defer ></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"defer ></script>

    <script>

        function initializeTools() {
            if ($("#show_tools").text() == "Hide Tools") {
                $("#show_tools").text("Show Tools");
                refresh_list();
            } else {
                var table = $('.kt-datatable__table');
                table.dataTable({
                    dom: 'B',
                    buttons: [
                        'copy', 'excel', 'pdf', 'print'
                    ],
                });
                $("#show_tools").text("Hide Tools");
            };
        };

        function scrollDown() {
            window.scrollTo({left: 0, top: document.body.scrollHeight, behavior: "smooth"});
        }


    $(document).ready(function() {

        $('.js-basic-single').select2();


        refresh_list();

    });

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


    function refresh_list() {

        $("#my_table").html('');
        $("#my_table").append('<div class="kt-datatable" id="kt_apps_user_list_datatable"></div>');

        "use strict";

        var KTUserListDatatable = function() {

            // variables
            var datatable;

            // init
            var init = function() {

                datatable = $('#kt_apps_user_list_datatable').KTDatatable({
                    // datasource definition
                    data: {
                        type: 'remote',
                        source: {
                            read: {
                                url: '/UserList',
                                method: 'get',
                                contentType: 'application/json',
                            },
                        },
                        pageSize: 20, // display 20 records per page
                        serverPaging: false,
                        serverFiltering: false,
                        serverSorting: false,
                    },

                    // layout definition
                    layout: {
                        scroll: false, // enable/disable datatable scroll both horizontal and vertical when needed.
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
                        field: 'id',
                        title: 'ID',
                        sortable: true,
                        width: 50,
                    }, {
                        field: "name",
                        title: "User",
                        width: "auto",
                        // callback function support for column rendering
                        template: function(data) {
                            var output = '';
                                output = '<div class="kt-user-card-v2">\
                                            <div class="kt-user-card-v2__pic">\
                                                <img src="{{ url('/') }}/storage/uploads/avatars/' + data.avatar + '" alt="photo">\
                                            </div>\
                                            <div class="kt-user-card-v2__details">\
                                                <a href="#" class="kt-user-card-v2__name">' + data.name + '</a>\
                                                <span class="kt-user-card-v2__desc">' + data.username + '</span>\
                                            </div>\
                                        </div>';

                            return output;
                                }
                    }, {
                        field: 'email',
                        title: 'email',
                        type: 'email',
                    }, {
                        field: 'username',
                        title: 'User Name',
                    }, {
                        field: "status",
                        title: "Status",
                        width: 100,
                        // callback function support for column rendering
                        template: function(row) {
                            var status = {
                                0: {
                                    'title': 'For Activation',
                                    'class': ' btn-label-warning'
                                },
                                1: {
                                    'title': 'Active',
                                    'class': ' btn-label-success'
                                },
                                2: {
                                    'title': 'Deactivated',
                                    'class': ' btn-label-danger'
                                },
                                3: {
                                    'title': 'Blocked',
                                    'class': ' btn-label-danger'
                                }
                            };
                            return '<span class="btn btn-bold btn-sm btn-font-sm ' + status[row.status].class + '">' + status[row.status].title + '</span>';
                        }
                    }, {
                        width: 110,
                        field: 'type',
                        title: 'Type',
                        autoHide: false,
                        // callback function support for column rendering
                            template: function(row) {
                                var status = {
                                    0: {'title': 'Guest', 'state': 'warning'},
                                    1: {'title': 'User', 'state': 'primary'},
                                    2: {'title': 'Manager', 'state': 'primary'},
                                    3: {'title': 'Cashier', 'state': 'success'},
                                    4: {'title': 'Super Admin', 'state': 'danger'},
                                };
                            return '<span class="kt-badge kt-badge--' + status[row.type].state + ' kt-badge--dot"></span>&nbsp;<span class="kt-font-bold kt-font-' + status[row.type].state + '">' +
                                status[row.type].title + '</span>';
                        },
                    }, {
                        field: 'store_id',
                        title: 'Assigned Store',
                            template: function(data) {
                                var output = '';
                                output = '<div class="kt-user-card-v2__details">\
                                                    <a href="#" class="kt-user-card-v2__name">' + data.address1 + '</a>\
                                                    <span class="kt-user-card-v2__desc">' + data.address2 + '</span>\
                                                </div>';
                                return output;
                            }
                    }, {
                        field: "actions",
                        width: 80,
                        title: "Actions",
                        sortable: false,
                        autoHide: false,
                        overflow: 'visible',
                        template: function(data) {
                            var record_id  = data.id ;
                            var show_url = "/users/:id";
                            var edit_url = "/users/:id/edit";
                            var delete_url = "/users/:id";

                            show_url = show_url.replace(':id',record_id);
                            edit_url = edit_url.replace(':id',record_id);
                            delete_url = delete_url.replace(':id',record_id);

                            return '\<div class="dropdown">\
                                <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown">\
                                    <i class="flaticon-more-1"></i>\
                                </a>\
                                <div class="dropdown-menu dropdown-menu-right">\
                                    <ul class="kt-nav">\
                                        <li class="kt-nav__item">\
                                            <a href=' + show_url + ' class="kt-nav__link">\
                                                <i class="kt-nav__link-icon flaticon2-expand"></i>\
                                                <span class="kt-nav__link-text">View</span>\
                                            </a>\
                                        </li>\
                                        <li class="kt-nav__item">\
                                            <a href=' + edit_url + ' class="kt-nav__link">\
                                                <i class="kt-nav__link-icon flaticon2-contract"></i>\
                                                <span class="kt-nav__link-text">Edit</span>\
                                            </a>\
                                        </li>\
                                        <li class="kt-nav__item">' +
                                                '<a title="Delete" href="" class="kt-nav__link" id="remove-record"' +
                                                    'data-toggle="modal"' +
                                                    'data-url="' + delete_url  + '"' +
                                                    'data-id="' + data.id   + '"' +
                                                    'data-title="' + data.name   + '"' +
                                                    'data-type="User"' +
                                                    'data-target="#custom-width-modal">\
                                                    <i class="kt-nav__link-icon flaticon2-trash"></i>\
                                                    <span class="kt-nav__link-text">Delete</span>\
                                                </a>\
                                        </li>\
                                        <li class="kt-nav__item">\
                                            <a href="#" class="kt-nav__link">\
                                                <i class="kt-nav__link-icon flaticon2-mail-1"></i>\
                                                <span class="kt-nav__link-text">Export</span>\
                                            </a>\
                                        </li>\
                                    </ul>\
                                </div>\
                            </div>\
                            ';

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
                //$('#kt_form_status, #kt_form_type').selectpicker();

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
            KTUserListDatatable.init();
        });

    };

</script>
@endsection
