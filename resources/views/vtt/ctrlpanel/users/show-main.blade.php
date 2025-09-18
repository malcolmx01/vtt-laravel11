@extends('vtt.layouts.main')

@section('page','Users')
@section('description','User Details')
@section('header-component')
    <a href="#" class="btn kt-subheader__btn-primary">
        Actions &nbsp;
        <i class="flaticon2-calendar-1"></i>
    </a>

    <a href="{{route('users.index')}}" class="btn btn-default btn-icon-sm">
        <i class="la la-list-ol"></i>
        User Archive
    </a>
@endsection

@section('content')
    <div class="col-xl-12">
        <div class="kt-portlet kt-portlet--height-fluid kt-portlet--mobile ">
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
                    <span class="kt-portlet__head-icon">
                        <i class="kt-font-brand flaticon2-user"></i>
                    </span>
                    <h3 class="kt-portlet__head-title">
                        Users Details
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        <div class="kt-portlet__head-actions">
                            <a href="{{route('users.edit', $user->id)}}" class="btn btn-default btn-icon-sm">
                                <i class="la la-edit"></i>
                                Edit Details
                            </a>
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
                <div class="p-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-3"><strong>Name</strong></div>
                                <div class="col-md-9">{{$user->name}}</div>
                            </div>
                            <div class="row">
                                <div class="col-md-3"><strong>Email Address</strong></div>
                                <div class="col-md-9">{{$user->email}}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="box-roles-info">
                                        <label class="label"><strong>Roles</strong></label>
                                        <ul>
                                            @forelse ($user->roles as $role)
                                                <li>{{$role->display_name}} ({{$role->description}})</li>
                                            @empty
                                                <p>This user has not been assigned any roles yet</p>
                                            @endforelse
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end: Datatable -->
            </div>
        </div>
    </div>

@endsection
