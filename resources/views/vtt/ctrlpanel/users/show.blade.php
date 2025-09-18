@extends('vtt.layouts.main')
@section('content')
    {{--<div class="row">--}}
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{route('users.index')}}"><span class="lnr-users2"></span> Manage Users</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><span class="lnr-user"></span> View User Details</li>
                </ol>
            </nav>
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><span class="lnr-user"></span> View User Details
                         <a class="btn btn-primary float-right" href="{{route('users.edit', $user->id)}}"><span class="la la-pencil"></span> Edit User Details</a>
                        <a href="#"><span ></span> </a></a>
                         <a class="btn btn-success float-right" href="/view_user_profile/{{$user->id}}"><span class="la la-search"></span> Show User Profile</a>
                    </h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-4"><strong>User Name:</strong></div>
                                <div class="col-md-8">{{$user->username}}</div>
                            </div>
                            <div class="row">
                                <div class="col-md-4"><strong>Full Name:</strong></div>
                                <div class="col-md-8">{{$user->name}}</div>
                            </div>
                            <div class="row">
                                <div class="col-md-4"><strong>Email Address:</strong></div>
                                <div class="col-md-8">{{$user->email}}</div>
                            </div>

                            <div class="row">
                                <div class="col-md-4"><strong>Company:</strong></div>
                                <div class="col-md-8">{{$user->company}}</div>
                            </div>

                            <div class="row">
                                <div class="col-md-4"><strong>Contact Number/s:</strong></div>
                                <div class="col-md-8">{{$user->contact_nos}}</div>
                            </div>

                            <div class="row">
                                <div class="col-md-4"><strong>Assigned Partner:</strong></div>
                                <div class="col-md-8">
                                    {{ Form::select('partner', $partner_list, $user->partner_id, ['disabled'=>'disabled']) }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4"><strong>Account Status:</strong></div>
                                <div class="col-md-8">
                                    @switch($user->status)
                                        @case(0)
                                            For Activation
                                        @break
                                        @case(1)
                                            Active
                                        @break
                                        @case(2)
                                            For Activation
                                        @break
                                        @case(3)
                                            Blocked
                                        @break
                                    @endswitch
                                </div>
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
            </div>
        </div>
    {{--</div>--}}
@endsection


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>

    $(document).ready(function() {

        $('.js-basic-single').select2();


    });

</script>
