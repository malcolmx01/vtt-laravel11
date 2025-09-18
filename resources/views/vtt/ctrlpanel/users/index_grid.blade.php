@extends('vtt.layouts.main')
@section('page','Users')
@section('description','User archive')
@section('header-component')
    <a href="#" class="btn kt-subheader__btn-primary">
        Actions &nbsp;
        <i class="flaticon2-calendar-1"></i>
    </a>
@endsection

@section('content')
        <div class="kt-portlet kt-portlet--height-fluid kt-portlet--mobile ">
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
										<span class="kt-portlet__head-icon">
											<i class="kt-font-brand flaticon2-user"></i>
										</span>
                    <h3 class="kt-portlet__head-title">
                        User Archive
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        <div class="kt-portlet__head-actions">
                            <div class="dropdown dropdown-inline">
                                <button type="button" class="btn btn-default btn-icon-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="la la-download"></i> Export
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <ul class="kt-nav">
                                        <li class="kt-nav__section kt-nav__section--first">
                                            <span class="kt-nav__section-text">Choose an option</span>
                                        </li>
                                        <li class="kt-nav__item">
                                            <a href="#" class="kt-nav__link">
                                                <i class="kt-nav__link-icon la la-print"></i>
                                                <span class="kt-nav__link-text">Print</span>
                                            </a>
                                        </li>
                                        <li class="kt-nav__item">
                                            <a href="#" class="kt-nav__link">
                                                <i class="kt-nav__link-icon la la-copy"></i>
                                                <span class="kt-nav__link-text">Copy</span>
                                            </a>
                                        </li>
                                        <li class="kt-nav__item">
                                            <a href="#" class="kt-nav__link">
                                                <i class="kt-nav__link-icon la la-file-excel-o"></i>
                                                <span class="kt-nav__link-text">Excel</span>
                                            </a>
                                        </li>
                                        <li class="kt-nav__item">
                                            <a href="#" class="kt-nav__link">
                                                <i class="kt-nav__link-icon la la-file-text-o"></i>
                                                <span class="kt-nav__link-text">CSV</span>
                                            </a>
                                        </li>
                                        <li class="kt-nav__item">
                                            <a href="#" class="kt-nav__link">
                                                <i class="kt-nav__link-icon la la-file-pdf-o"></i>
                                                <span class="kt-nav__link-text">PDF</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            &nbsp;
                            <a href="{{route('users.create')}}" class="btn btn-brand btn-elevate btn-icon-sm">
                                <i class="la la-plus"></i>
                                Add
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="kt-portlet__body kt-portlet__body--fit">
                <!--begin: Datatable -->
                <div class="px-4">
                    <table class="table table-striped table-bordered table-hover table-checkable" id="kt_table_4">
                        <thead>
                        <tr>
                            <th>id</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Date Created</th>
                            <th>Actions</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <th>{{$user->id}}</th>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->created_at->toFormattedDateString()}}</td>
                                <td>
                                    <a href="{{route('users.show', $user->id)}}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Show details">
                                        <i class="la la-eye"></i>
                                    </a>
                                    <a href="{{route('users.edit', $user->id)}}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit details">
                                        <i class="la la-pencil"></i>
                                    </a>
                                    <a title="Delete" href="" class="remove-record"
                                       data-toggle="modal"
                                       data-url="{!! URL::route('users.destroy', $user->id) !!}"
                                       data-id="{{$user->id}}"
                                       data-title="{{$user->name}}"
                                       data-type="User"
                                       data-target="#custom-width-modal"><span class="la la-trash"></span></a>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
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
    <script>
        $(document).ready(function(){
            // For A Delete Record Popup
            $('.remove-record').click(function() {
                var id = $(this).attr('data-id');
                var url = $(this).attr('data-url');
                var title = $(this).attr('data-title');
                var type = $(this).attr('data-type');
                var token = $('meta[name="csrf-token"]').attr('content');
                $(".remove-record-model").attr("action",url);
                // console.log('ber---'+$(".remove-record-model").attr("action",url));
                $('body').find('.post-record-id').text(id);
                $('body').find('.post-record-type').text(type);
                $('body').find('.post-record-title').text(title);

                $('body').find('.remove-record-model').append('<input name="_token" type="hidden" value="'+ token +'">');
                $('body').find('.remove-record-model').append('<input name="_method" type="hidden" value="delete">');
                $('body').find('.remove-record-model').append('<input name="id" type="hidden" value="'+ id +'">');
            });

            $('.remove-data-from-delete-form').click(function() {
                $('body').find('.remove-record-model').find( "input" ).remove();
            });
            $('.modal').click(function() {
                // $('body').find('.remove-record-model').find( "input" ).remove();
            });
        });
    </script>

@endsection
