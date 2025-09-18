@extends('vtt.layouts.main')
@section('content')

    {{--<div class="row">--}}
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{route('users.index')}}"><span class="lnr-users2"></span> Manage Users</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><span class="lnr-pencil"></span> Edit User</li>
                </ol>
            </nav>
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><span class="lnr-pencil"></span> Edit User <a href="{{route('users.index')}}" class="btn btn-secondary float-right"><span class="lnr-list"></span> View All User</a></h3>
                </div>
                <form action="{{route('users.update', $user->id)}}" method="POST">
                    <div class="box-body">
                        {{method_field('PUT')}}
                        {{csrf_field()}}
                        <div class="row">
                            <div class="col-md-6">

                                <div class="form-group row">
                                    <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('User Name') }}</label>

                                    <div class="col-md-6">
                                        <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{$user->username}}"  required autofocus>

                                        @if ($errors->has('username'))
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('username') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Full Name') }}</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{$user->name}}"  required autofocus>

                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('User Type') }}</label>
                                    <div class="col-md-6">
                                        {{ Form::select('class',
                                                array(
                                                 '1' => 'Employee',
                                                 '2' => 'Partner'), $user->class,
                                                 [  'id'                            => 'class',
                                                    'name'                            => 'class',
                                                    'placeholder' => '-- pls enter user type --',
                                                    'class'                         => 'js-basic-single form-control',
                                                    'data-parsley-trigger'          => 'keyup change focusout',
                                                    'data-parsley-class-handler'    => '#class-group',
                                                    'required'=>'required',
                                                     'style'=>'width: 100%']
                                                )}}
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="staus" class="col-md-4 col-form-label text-md-right">{{ __('Level') }}</label>

                                    <div class="col-md-6">
                                        <select name="level" id="level" class="js-basic-single form-control{{ $errors->has('level') ? ' is-invalid' : '' }}" required>
                                            <option value="0" @if($user->level == 0) selected @endif >N/A</option>
                                            <option value="1" @if($user->level == 1) selected @endif >Clerk</option>
                                            <option value="2" @if($user->level == 2) selected @endif >Receiver</option>
                                            <option value="3" @if($user->level == 3) selected @endif >Med Tech</option>
                                            <option value="4" @if($user->level == 4) selected @endif >Approver</option>
                                            <option value="5" @if($user->level == 5) selected @endif >Head Pathologist</option>
                                        </select>

                                        @if ($errors->has('level'))
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('level') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{$user->email}}"  required>

                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">

                                    <label for="password" class="col-md-4 col-form-label text-md-right"><span v-if="new_password">Password</span></label>

                                    <div class="col-md-6">

                                        <input id="password" type="password" v-if="new_password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="New Password">
                                        {{--<span v-if="new_password"><b-form-checkbox name="showPassword" class="mt-2" id="showPassword"> Show Password? </b-form-checkbox></span>--}}

                                        <b-form-checkbox name="newpassword" class="mt-2" v-model="new_password">Change password?</b-form-checkbox>

                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="staus" class="col-md-4 col-form-label text-md-right">{{ __('Assigned Partner') }}</label>
                                    <div class="col-md-6">
                                        {!! Form::select('partner', $partner_list, $user->partner_id, ['class' => 'js-basic-single form-control', 'placeholder'=>'-- pls enter partner --','style'=>'width: 100%']) !!}
                                        <span><a type="btn" class="btn-xs btn-hover-success" data-toggle="modal" data-target="#add-new-partner-modal">Add new Partner not found in the list!</a> </span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="staus" class="col-md-4 col-form-label text-md-right">{{ __('Assigned Clinic Address') }}</label>
                                    <div class="col-md-6">
                                        <select id="store_id" name="store_id" class="js-basic-single form-control">
                                            <option value="0" disabled selected="true">-- Select Assigned Clinic --</option>
                                            @foreach($companyProfile as $store)
                                                <option value="{{$store->id}}" {{ $store->id == $user->store_id ? 'selected' : '' }}>
                                                    {{$store->company .", ". $store->address1 }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="staus" class="col-md-4 col-form-label text-md-right">{{ __('Status') }}</label>

                                    <div class="col-md-6">

                                        <select name="status" id="status" class="js-basic-single form-control{{ $errors->has('status') ? ' is-invalid' : '' }}" required>
                                            <option value="0" @if($user->status == 0) selected @endif >For Activation</option>
                                            <option value="1" @if($user->status == 1) selected @endif >Active</option>
                                            <option value="2" @if($user->status == 2) selected @endif >Deactivated</option>
                                            <option value="3" @if($user->status == 3) selected @endif >Blocked</option>
                                        </select>

                                        @if ($errors->has('status'))
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('status') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>


                            </div>
                            <div class="col-md-6">
                                <label for="roles" class="label">Roles:</label>
                                <b-form-group v-cloak>
                                    {{--<b-form-check-group id="rolesCheckboxes" name="roles">--}}
                                    {{--<b-form-check-group>--}}
                                    @foreach ($roles as $role)
                                        <div>
                                            <b-form-checkbox v-model="roleselected" value="{{$role->id}}">{{$role->display_name}}</b-form-checkbox>
                                        </div>
                                    @endforeach
                                    {{--</b-form-check-group>--}}
                                    {{--</b-form-check-group>--}}
                                </b-form-group>
                                <input type="hidden" name="roles" :value="roleselected" />
                                {{--<div>Selected: <strong>@{{ roleselected }}</strong></div>--}}
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <button class="btn btn-primary px-5"><span class="lnr-pencil5"></span> Update User</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    {{--</div>--}}
@endsection

@section('modal')
    <!-- Add Partner -->
    <form action="{{route('partners.store')}}" enctype="multipart/form-data" method="POST" class="remove-record-model">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div id="add-new-partner-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true">
            <div class="modal-dialog" style="width:100%;">
                <div class="modal-content square shadow">
                    <div class="modal-header">
                        <h5 class="modal-title" id="custom-width-modalLabel">Add Partner</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <div>
                            <div class="kt-wizard-v4__form">

                                <div class="row">
                                    <div class="form-group col-sm-4">
                                        {{Form::label('type','Partner Type')}}<span><sup style="color: red; font-weight: bold">*</sup></span>
                                        {{ Form::select('type',
                                                array(
                                                 '1' => 'Individual',
                                                 '2' => 'Group'), '',
                                                 [  'id'                            => 'type',
                                                    'name'                            => 'type',
                                                    'placeholder' => '-- pls enter Type --',
                                                    'class'                         => 'js-basic-single form-control',
                                                    'data-parsley-trigger'          => 'keyup change focusout',
                                                    'data-parsley-class-handler'    => '#type-group',
                                                    'required'=>'required',
                                                     'style'=>'width: 100%']
                                                )}}
                                    </div>
                                    <div class="form-group col-sm-8">
                                        {{Form::label('partner','Partner')}}<span><sup style="color: red; font-weight: bold">*</sup></span>
                                        {{Form::text('partner','',['class'=>'form-control', 'placeholder'=>'-- pls enter partner name --', 'required'=>'required','style'=>'width: 100%'])}}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-4">
                                        {{Form::label('payment_type','Payment Mode')}}<span><sup style="color: red; font-weight: bold">*</sup></span>
                                        {!! Form::select('payment_type', $payment_type_list,'', ['class' => 'js-basic-single form-control', 'style'=>'width: 100%', 'required'=>'required','style'=>'width: 100%']) !!}
                                    </div>

                                    <div class="form-group col-sm-8">
                                        {{Form::label('contact_person','Contact person')}}<span><sup style="color: red; font-weight: bold">*</sup></span>
                                        {{Form::text('contact_person','',['class'=>'form-control', 'placeholder'=>'-- pls enter contact person --', 'required'=>'required','style'=>'width: 100%'])}}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        {{Form::label('contact_nos','Contact No(s)')}}<span><sup style="color: red; font-weight: bold">*</sup></span>
                                        {{Form::text('contact_nos','',['class'=>'form-control', 'placeholder'=>'-- pls enter contact nos --', 'required'=>'required','style'=>'width: 100%'])}}
                                    </div>
                                    <div class="form-group col-sm-6">
                                        {{Form::label('email','Email')}}
                                        {{Form::email('email','',['class'=>'form-control', 'placeholder'=>'-- pls enter email --'])}}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-12">
                                        {{Form::label('address','Address')}}<span><sup style="color: red; font-weight: bold">*</sup></span>
                                        {{Form::text('address','',['class'=>'form-control', 'placeholder'=>'-- pls enter address --', 'required'=>'required','style'=>'width: 100%'])}}
                                    </div>
                                </div>

                                <div class="row">
                                    <label for="with_agent" class="col-sm-2 col-form-label">{{ __('With Agent:') }}</label>
                                    <div class="col-sm-2">
                                        <input id="with_agent" type="checkbox" class="form-control" name="with_agent" value = "0" style = 'width: 100%'>
                                    </div>

                                    <div class="form-group col-sm-8">
                                        {{Form::label('agent','Agent')}}
                                        {!! Form::select('agent', $agent_list, '', ['class' => 'js-basic-single form-control', 'style'=>'width: 100%']) !!}
                                        <span><a type="btn" class="btn-xs btn-hover-success" data-toggle="modal" data-target="#add-new-agent-modal">Add new Agent not found in the list!</a> </span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        {{Form::label('discount','Discount (%)')}}
                                        <input type="number" min="0" class='form-control' name="discount" id="discount" pattern="^\d*(\.\d{0,2})?$" placeholder ='-- pls enter discount --' value = "0" style = 'width: 100%'/>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        {{Form::label('commission','Commission (%)')}}
                                        <input type="number" min="0" class='form-control' name="commission" id="commission" pattern="^\d*(\.\d{0,2})?$" placeholder ='-- pls enter commission --' value = "0"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-4">
                                        <label>Account Status:</label>
                                        <select name="status" id="partner_status" class="js-basic-single form-control" required style = 'width: 100%'>
                                            <option value="1">Active</option>
                                            <option value="2">For Activation</option>
                                        </select>

                                        @if ($errors->has('status'))
                                            <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('status') }}</strong></span>
                                        @endif
                                    </div>
                                </div>

                                <small>Logo Image file:</small>
                                <div class="form-group">
                                    {{Form::file('logo')}}
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-success waves-effect waves-light"><span class="lnr-checkmark-circle"></span> Save</button>
                        <button type="button" class="btn btn-sm btn-default waves-effect remove-data-from-delete-form" data-dismiss="modal"><span class="lnr-cross-circle"></span> Close</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Add Agent -->
    <form action="{{route('agents.store')}}" enctype="multipart/form-data" method="POST" class="remove-record-model">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div id="add-new-agent-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true">
            <div class="modal-dialog" style="width:100%;">
                <div class="modal-content square shadow">
                    <div class="modal-header">
                        <h5 class="modal-title" id="custom-width-modalLabel">Add Agent</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <div>
                            <div class="kt-wizard-v4__form">
                                <div class="row">
                                    <div class="form-group col-sm-4">
                                        {{Form::label('type','Agent Type:')}}<span><sup style="color: red; font-weight: bold">*</sup></span>
                                        {{ Form::select('type',
                                                array(
                                                 '1' => 'Individual',
                                                 '2' => 'Group'), '',
                                                 [  'id'                            => 'agent_type',
                                                    'name'                            => 'type',
                                                    'placeholder' => '-- enter Type --',
                                                    'class'                         => 'js-basic-single form-control',
                                                    'data-parsley-trigger'          => 'keyup change focusout',
                                                    'data-parsley-class-handler'    => '#type-group',
                                                    'required'=>'required',
                                                     'style'=>'width: 100%' ]
                                                )}}
                                    </div>
                                    <div class="form-group col-sm-8">
                                        {{Form::label('agent','Agent')}}<span><sup style="color: red; font-weight: bold">*</sup></span>
                                        {{Form::text('agent','',['class'=>'form-control', 'placeholder'=>'-- pls enter agent name --', 'required'=>'required'])}}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-sm-12">
                                        {{Form::label('address','Address')}}<span><sup style="color: red; font-weight: bold">*</sup></span>
                                        {{Form::text('address','',['class'=>'form-control', 'placeholder'=>'-- pls enter address --', 'required'=>'required', 'style'=>'width: 100%' ])}}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        {{Form::label('contact_person','Contact person')}}<span><sup style="color: red; font-weight: bold">*</sup></span>
                                        {{Form::text('contact_person','',['class'=>'form-control', 'placeholder'=>'-- pls enter contact person --', 'required'=>'required', 'style'=>'width: 100%' ])}}
                                    </div>
                                    <div class="form-group col-sm-6">
                                        {{Form::label('contact_nos','Contact No(s)')}}<span><sup style="color: red; font-weight: bold">*</sup></span>
                                        {{Form::text('contact_nos','',['class'=>'form-control', 'placeholder'=>'-- pls enter contact nos --', 'required'=>'required', 'style'=>'width: 100%' ])}}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-sm-4">
                                        {{Form::label('commission','Comm. (%)')}}
                                        <input type="number" min="0" class='form-control' name="commission" id="commission" pattern="^\d*(\.\d{0,2})?$" placeholder ='-- enter commission --' value = "0" style = 'width: 100%'/>
                                    </div>
                                    <div class="form-group col-sm-8">
                                        {{Form::label('email','Email')}}
                                        {{Form::email('email','',['class'=>'form-control', 'placeholder'=>'-- enter email --', 'style'=>'width: 100%' ])}}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-sm-4">
                                        <label>Account Status:</label>
                                        <select name="status" id="agent_status" class="js-basic-single form-control" required style = 'width: 100%' >
                                            <option value="1">Active</option>
                                            <option value="2">For Activation</option>
                                        </select>

                                        @if ($errors->has('status'))
                                            <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('status') }}</strong></span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    {{Form::file('logo')}}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-success waves-effect waves-light"><span class="lnr-checkmark-circle"></span> Save</button>
                        <button type="button" class="btn btn-sm btn-default waves-effect remove-data-from-delete-form" data-dismiss="modal"><span class="lnr-cross-circle"></span> Close</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    {{--<script src="{{ asset('js/app8.js') }}"></script>--}}

    <script>
        var app = new Vue({
            el: '#app',
            data: {
                new_password: false,
                roleselected: {!! $user->roles->pluck('id') !!},
            }
        });

        $(document).ready(function() {

            $('.js-basic-single').select2();


        });
    </script>
@endsection
