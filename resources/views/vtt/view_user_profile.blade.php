@extends('vtt.layouts.main')
@section('content')
    {{--<div class="ctrlheader"></div>--}}
    {{--<div style="height: 360px"></div>--}}

    <div class="col-lg-12">
        <div class="row pt-2">

        <!--begin::Portlet-->
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="kt-portlet__head-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <polygon points="0 0 24 0 24 24 0 24"/>
                                <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>
                            </g>
                        </svg>
                    </span>
                    <h3 class="kt-portlet__head-title">
                        Profile | Personal Information
                    </h3>
                </div>
            </div>
            <form enctype="multipart/form-data" action="/update_profile" method="POST">
                <div class="kt-portlet__body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <input id="id" name="id" value="{{$user->id}}" type="hidden">

                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">
                            {{ $error }}
                        </div>
                    @endforeach

                        <div class="row mb-5">
                            <div class="col-md-10">
                                <div class="form-group col-sm-9">
                                    <img src="/storage/uploads/avatars/{{ $user->avatar }}"  class="profile-avatar-image" />
                                    <span class="profile-avatar"><h4>{{ $user->name }}</h4></span>
                                    <div class="form-group">
                                        {{Form::file('avatar')}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Account Status:</label>

                                    <select name="status" id="status" class="js-basic-single form-control{{ $errors->has('status') ? ' is-invalid' : '' }}" disabled required style = 'width: 100%'>
                                        <option value="0" @if($user->status == 2) selected @endif >For Activation</option>
                                        <option value="1" @if($user->status == 1) selected @endif >Active</option>
                                        <option value="2" @if($user->status == 2) selected @endif >For Activation</option>
                                    </select>

                                    @if ($errors->has('status'))
                                        <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('status') }}</strong>
                                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="row">
                            <div class="form-group col-sm-2">
                                {{Form::label('class','User Type:')}}<span><sup style="color: red; font-weight: bold">*</sup></span>
                                {{ Form::select('class',
                                        array(
                                         '1' => 'Employee',
                                         '2' => 'Partner'), $user->class,
                                         [  'id'                            => 'class',
                                            'name'                            => 'class',
                                            'placeholder' => '-- pls enter Type --',
                                            'class'                         => 'js-basic-single form-control',
                                            'data-parsley-trigger'          => 'keyup change focusout',
                                            'data-parsley-class-handler'    => '#class-group',
                                            'required'=>'required',
                                             'style'=>'width: 100%',
                                             'disabled'=>'disabled']
                                        )}}
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {{Form::label('first_name','First Name:')}}<span><sup style="color: red; font-weight: bold">*</sup></span>
                                    {{Form::text('first_name',$user->first_name, ['class'=>'form-control', 'placeholder'=>'First Name', 'id'=>'first_name', 'required' => 'required','style'=>'width: 100%'])}}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {{Form::label('middle_name','Middle Name:')}}
                                    {{Form::text('middle_name',$user->middle_name,['class'=>'form-control', 'placeholder'=>'Middle Name', 'id'=>'middle_name','style'=>'width: 100%'])}}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">

                                    {{Form::label('last_name','Last Name:')}}<span><sup style="color: red; font-weight: bold">*</sup></span>
                                    {{Form::text('last_name',$user->last_name,['class'=>'form-control', 'placeholder'=>'Last Name', 'id'=>'last_name', 'required' => 'required','style'=>'width: 100%'])}}
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">

                                    {{Form::label('suffix','Suffix:')}}
                                    {{ Form::select('suffix',
                                    array(
                                     'Jr.' => 'Jr.',
                                     'Sr.' => 'Sr.',
                                     'I' => 'I',
                                     'II' => 'II',
                                     'III' => 'III',
                                     'IV' => 'IV',
                                     'V' => 'V',
                                     'VI' => 'VI',
                                     'VII' => 'VII',
                                     'VIII' => 'VIII',
                                     'IX' => 'IX',
                                     'X' => 'X',
                                     'XI' => 'XI',
                                     'XII' => 'XII',
                                     'XIII' => 'XIII',
                                     'XIV' => 'XIV',
                                     'XV' => 'XV',
                                     'XVI' => 'XVI',
                                     'XVII' => 'XVII',
                                     'XVIII' => 'XVIII',
                                     'XIX' => 'XIX',
                                     'XX' => 'XX',
                                     '' => "N/A"), $user->suffix,
                                     [  'id'                            => 'suffix',
                                        'name'                            => 'suffix',
                                        'placeholder' => 'Select',
                                        'class'                         => 'js-basic-single form-control',
                                        'data-parsley-trigger'          => 'keyup change focusout',
                                        'data-parsley-minlength'        => '1',
                                        'data-parsley-maxlength'        => '5',
                                        'data-parsley-class-handler'    => '#suffix-group',
                                        'style'=>'width: 100%']
                                    )}}
                                </div>
                            </div>
                            {{--<div class="col-md-4">
                                <div class="form-group">
                                    <div class="form-group">
                                    {{Form::label('name','Name:')}}--}}
                            {{Form::hidden('name',$user->name,['class'=>'form-control', 'placeholder'=>'Full Name', 'id'=>'name'])}}
                            {{--</div>
                        </div>
                    </div>--}}

                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    {{Form::label('username','User Name:')}}<span><sup style="color: red; font-weight: bold">*</sup></span>
                                    {{Form::text('username',$user->username,['class'=>'form-control', 'placeholder'=>'User Name', 'id'=>'username','required'=>'required','style'=>'width: 100%'])}}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {{Form::label('email','email:')}}<span><sup style="color: red; font-weight: bold">*</sup></span>
                                    {{Form::text('email',$user->email,['class'=>'form-control', 'placeholder'=>'email', 'id'=>'email','required'=>'required','style'=>'width: 100%'])}}
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    {{Form::label('contact_nos','Contact Nos:')}}<span><sup style="color: red; font-weight: bold">*</sup></span>
                                    {{Form::text('contact_nos',$user->contact_nos,['class'=>'form-control', 'placeholder'=>'Contact Nos', 'id'=>'contact_nos','required'=>'required','style'=>'width: 100%'])}}
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    {{Form::label('birthday','Birthday:')}}<span><sup style="color: red; font-weight: bold">*</sup></span>
                                    {{Form::text('birthday', date('m/d/Y', strtotime($user->birthday)),['class'=>'form-control','placeholder'=>'-- pls enter Birthday --', 'id'=>'birthday', 'required','style'=>'width: 100%' ])}}<span class="input-group-addon"></span>

                                    {{--{{Form::date('birthday',$user->birthday,['class'=>'form-control', 'placeholder'=>'Birthday', 'id'=>'birthday','required'=>'required','style'=>'width: 100%'])}}--}}
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    {{Form::label('gender','Sex:')}}<span><sup style="color: red; font-weight: bold">*</sup></span>
                                    {{ Form::select('gender',
                                            array(
                                             'M' => 'Male',
                                             'F' => 'Female'), $user->gender,
                                             [  'id'                            => 'gender',
                                                'name'                            => 'gender',
                                                'required'=>'required',
                                                'placeholder' => '-- pls input Gender --',
                                                'class'                         => 'js-basic-single form-control',
                                                'data-parsley-trigger'          => 'keyup change focusout',
                                                'data-parsley-class-handler'    => '#gender-group',
                                                'style'=>'width: 100%']
                                            )}}
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    {{Form::label('civil_status','Civil Status:')}}<span><sup style="color: red; font-weight: bold">*</sup></span>
                                    {{ Form::select('civil_status',
                                            array(
                                             '1' => 'Single',
                                             '2' => 'Married',
                                             '3' => 'Widowed',
                                             '4' => 'Separated',
                                             '5' => 'Divorced'), $user->civil_status,
                                             [  'id'                            => 'civil_status',
                                                'name'                            => 'civil_status',
                                                'required'=>'required',
                                                'placeholder' => '-- pls enter Civil Status --',
                                                'class'                         => 'js-basic-single form-control',
                                                'data-parsley-trigger'          => 'keyup change focusout',
                                                'data-parsley-class-handler'    => '#civil_status-group',
                                                'style'=>'width: 100%']
                                            )}}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    {{Form::label('province','Province:')}}
                                    <select id="userProvince" name="province_c" class="js-basic-single form-control" style = 'width: 100%'>
                                        <option value="0" disabled selected="true">-- Select Province --</option>
                                        @foreach($provinceList as $prov)
                                            <option value="{{$prov->PROVINCE_C}}" {{ $prov->PROVINCE_C == $user->PROVINCE_C ? 'selected' : '' }}>{{$prov->PROVINCE}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {{Form::label('Citymun','City/Municipality:')}}<span><sup style="color: red; font-weight: bold">*</sup></span>
                                    <select id="userCityMunicipality" name="citymun_id" class="js-basic-single form-control" required ="required" style = 'width: 100%'>
                                        <option value="0" disabled selected="true">-- Select CityMunicipality --</option>
                                        @foreach($cityMunicipalityList as $cityMun)
                                            <option value="{{$cityMun->CITYMUN_C}}" {{ $cityMun->CITYMUN_C == $user->CITYMUN_C ? 'selected' : '' }}>
                                                {{$cityMun->CITYMUN .", ". $cityMun->PROVINCE }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Barangay</label>
                                    <select id="userBarangay" name="userBarangay" class="js-basic-single form-control" style = 'width: 100%'>
                                        <option value="0" disabled selected="true">-- Select Barangay --</option>
                                        <option value= {{$user->BARANGAY_C }} disabled selected="true"> {!! $user->BARANGAY !!}</option>
                                        @foreach($barangayList as $barangay)
                                            <option value="{{$barangay->BARANGAY_C}}" {{ $barangay->BARANGAY_C == $user->BARANGAY_C ? 'selected' : '' }}>
                                                {{$barangay->BARANGAY}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <input type="hidden" id="uBarangay" name="uBarangay">
                            <input type="hidden" id="uRegion" name="uRegion" value=" {{ $user->REGION_C }}">
                            <input type="hidden" id="uProvince" name="uProvince" value=" {{ $user->PROVINCE_C }}">
                            <input type="hidden" id="uCityMunicipality" name="uCityMunicipality" value=" {{ $user->CITYMUN_C }}">

                            <div class="col-md-3">
                                <div class="form-group">
                                    {{Form::label('address_details','House/Unit No., Street, Village/Subdivision')}}
                                    {{Form::text('address_details',$user->address_details,['class'=>'form-control', 'placeholder'=>'House/Unit No., Street, Village/Subdivision', 'id'=>'address_details','style'=>'width: 100%'])}}
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    {{Form::label('partner','Assigned Partner:')}}
                                    {!! Form::select('referring_institution', $partner_list,$user->partner_id, ['class' => 'js-basic-single form-control', 'placeholder'=>'-- pls enter partner --','style'=>'width: 100%', 'disabled' => 'disabled']) !!}
                                    <span><a type="btn" class="btn-xs btn-hover-success" data-toggle="modal" data-target="#add-new-partner-modal">Add new Partner not found in the list!</a> </span>

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {{Form::label('company','Company:')}}
                                    {{Form::text('company',$user->company,['class'=>'form-control', 'placeholder'=>'Company', 'id'=>'company','style'=>'width: 100%'])}}
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Assigned Clinic</label><span><sup style="color: red; font-weight: bold">*</sup></span>
                                    <select id="store_id" name="store_id" class="js-basic-single form-control" required ="required" disabled style = 'width: 100%'>
                                        <option value="0" disabled selected="true">-- Select Assigned Store --</option>
                                        @foreach($companyProfile as $store)
                                            <option value="{{$store->id}}" {{ $store->id == $user->store_id ? 'selected' : '' }}>
                                                {{$store->company .", ". $store->address1 }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <label for="password" class="col-md-4 col-form-label text-md-right"><span v-if="new_password">Password</span></label>

                            <div class="col-md-4">

                                <input id="password" type="password" v-if="new_password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="New Password" style = 'width: 100%'>

                                <b-form-checkbox name="newpassword" class="mt-2" v-model="new_password">Change password?</b-form-checkbox>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                @endif
                            </div>
                        </div>

                </div>
                <div class="kt-portlet__foot">
                    <div class="row align-items-center">
                        <div class="col-lg-6 m--valign-middle">
                        </div>
                        <div class="col-lg-6 kt-align-right">
                            <button type="submit" class="btn btn-primary px-5" id="update_profile"><span class="icon lnr-pencil5"></span> Update</button>
                            <a href="/home" class="btn btn-default px-5"><span class="icon lnr-exit"></span> Close</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!--end::Portlet-->
        </div>
    </div>

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
    {{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>--}}

    <script>
        $(function () {
            $("#birthday").datepicker({
                format: 'mm/dd/yyyy',
                autoclose: true
            });
        });

        var app = new Vue({
            el: '#app',
            data: {
                new_password: false,
            }
        });

        $(document).ready(function() {

            $('.js-basic-single').select2();
            $('.js-basic-multiple').select2();

            // ---------- Changing Region that changesTblprovincevince Listing (filtered by Region)
            $(document).on('change', '#userRegion', function () {


                var reg_id = $(this).val();

                var op = " ";

                $("#uRegion").val(reg_id);

                $.ajax({
                    type: 'get',
                    url: '/listProvince',
                    data: {'id': reg_id},
                    success: function (data) {
                        op += '<option value="0" selected disable>-- Select Province --</option>';
                        for (var i = 0; i < data.length; i++) {
                            op += '<option value="' + data[i].PROVINCE_C + '">' + data[i].PROVINCE + '</option>';
                        }

                        $('#userProvince').html(" ");
                        $('#userProvince').html(op);

                        $('#uProvince').val(0);
                        $("#uCityMunicipality").val(0);

                    },
                    error: function () {
                    }
                });
            });

// ---------- On ChangTblprovincevince will change the CityMunicipalTblcityMun down list
            $(document).on('change', '#userProvince', function () {
                var prov_id = $(this).val();
                var op = '';

                $("#uProvince").val(prov_id);

                $.ajax({
                    type: 'get',
                    url: '/listCityMunicipality',
                    data: {'id': prov_id},
                    success: function (data) {
                        op += '<option value="0" selected disable>-- Select CityMunicipality --</option>';
                        for (var i = 0; i < data.length; i++) {
                            op += '<option value="' + data[i].CITYMUN_C + '">' + data[i].CITYMUN + '</option>';
                        }

                        $('#userCityMunicipality').html(" ");
                        $('#userCityMunicipality').append(op);

                        $("#uCityMunicipality").val(0);

                        $("#uRegion").val(data[0].REGION_C);

                    },
                    error: function () {

                    }
                });
            });

// ---------- On ChangTblprovincevince will change the CityMunicipalTblcityMun down list
/*            $(document).on('change', '#userCityMunicipality', function () {

                var cityMunicipality_id = $(this).val();

                $("#uCityMunicipality").val(cityMunicipality_id);

                $.ajax({
                    type: 'get',
                    url: '/getRegionProvince',
                    data: {'id': cityMunicipality_id},
                    success: function (data) {

                        $('#uRegion').val(data[0].REGION_C);
                        $('#uProvince').val(data[0].PROVINCE_C);

                    },
                    error: function () {

                    }
                });
            });*/

            $(document).on('change', '#userCityMunicipality', function () {

                var cityMunicipality_id = $(this).val();
                var op = '';

                $("#uCityMunicipality").val(cityMunicipality_id);

                $.ajax({
                    type: 'get',
                    url: '/listBarangay',
                    data: {'id': cityMunicipality_id},
                    success: function (data) {
                        op += '<option value="0" selected disable>-- Select Barangay --</option>';
                        for (var i = 0; i < data.length; i++) {
                            op += '<option value="' + data[i].BARANGAY_C + '">' + data[i].BARANGAY + '</option>';
                        }

                        /*op += '<option value="' + data[i].id + '">' + data[i].BARANGAY + ', '+ data[i].LGU_M + ', '+ data[i].province + '</option>';*/

                        $('#userBarangay').html(" ");
                        $('#userBarangay').append(op);

                        $("#uProvince").val(data[0].PROVINCE_C);
                        $("#uRegion").val(data[0].REGION_C);

                    },
                    error: function () {
                        alert("Error loading Barangay list!");
                    }
                });
            });

        });
    </script>
@endsection
