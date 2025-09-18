@extends('vtt.layouts.main')
@section('content')
    <!-- begin:: Content Head -->
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">
                    Employee Information
                </h3>
            </div>
            <div class="kt-subheader__toolbar">
                <a href="{{route('Employees.index')}}"class="btn btn-label-primary btn-icon-sm"><i aria-hidden="true" class="la la-list"></i>
                    Archive
                </a>&nbsp;
            </div>
        </div>
    </div>
    <!-- end:: Content Head -->

    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    Create New Employee Profile
                </h3>
            </div>
        </div>
        <div class="kt-portlet__body kt-portlet__body--fit p-4">
            <!--begin: Datatable -->
            {!! Form::open(['action' => 'EmployeesController@store','method'  => 'POST', 'enctype'=>'multipart/form-data']) !!}
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        {{Form::label('first_name','First Name:')}}<span><sup style="color: red; font-weight: bold">*</sup></span>
                        {{Form::text('first_name','', ['class'=>'form-control', 'placeholder'=>'-- pls enter First Name --', 'id'=>'first_name', 'required'=>'required' ])}}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        {{Form::label('middle_name','Middle Name:')}}<span><sup style="color: red; font-weight: bold">*</sup></span>
                        {{Form::text('middle_name','',['class'=>'form-control', 'placeholder'=>'-- pls enter Middle Name --', 'id'=>'middle_name', 'required'=>'required' ])}}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">

                        {{Form::label('last_name','Last Name:')}}<span><sup style="color: red; font-weight: bold">*</sup></span>
                        {{Form::text('last_name','',['class'=>'form-control', 'placeholder'=>'-- pls enter Last Name --',  'id'=>'last_name', 'required'=>'required' ])}}
                    </div>
                </div>
                <div class="col-md-3">
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
                         '' => "N/A"), '',
                         [  'id'                            => 'suffix',
                            'name'                            => 'suffix',
                            'class'                         => 'js-basic-single form-control',
                            'data-parsley-trigger'          => 'keyup change focusout',
                            'data-parsley-minlength'        => '1',
                            'data-parsley-maxlength'        => '5',
                            'data-parsley-class-handler'    => '#suffix-group' ]
                        )}}
                    </div>
                </div>
                {{Form::hidden('name', '',['class'=>'form-control', 'id'=>'name'])}}
            </div>
            <div class="row">

                <div class="form-group col-md-3">
                    {{Form::label('gender','Sex:')}}<span><sup style="color: red; font-weight: bold">*</sup></span>
                    <div class="row">
                        <div class="col-md-3">
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                {{ Form::radio('gender', 'M' , false, ['required'] ) }} Male
                            </div>
                            <div class="row">
                                {{ Form::radio('gender', 'F' , false , ['required'] ) }} Female
                            </div>

                            {{--                    {{ Form::select('gender',
                                                        array(
                                                         'M' => 'Male',
                                                         'F' => 'Female'), '',
                                                         [  'id'                            => 'gender',
                                                            'name'                            => 'gender',
                                                            'placeholder' => '-- pls enter Gender --',
                                                            'class'                         => 'js-basic-single form-control',
                                                            'data-parsley-trigger'          => 'keyup change focusout',
                                                            'data-parsley-class-handler'    => '#gender-group',
                                                            'required'=>'required' ]
                                                        )}}--}}
                        </div>
                    </div>
                </div>

                <div class="form-group col-md-3">
                    {{Form::label('birthday','Birthday:')}}<span><sup style="color: red; font-weight: bold">*</sup></span>
                    {{--<div id="birthday" class="input-group date" data-date-format="mm-dd-yyyy">
                        <input name="birthday" class="form-control" type="date" readonly />
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    </div>--}}

                    {{Form::text('birthday','',['class'=>'form-control', 'data-date-format'=>'mm/dd/yyyy', 'placeholder'=>'-- pls enter Birthday --', 'id'=>'birthday', 'required' ])}}<span class="input-group-addon"></span>

                    {{--{{Form::date('birthday','',['class'=>'form-control','placeholder'=>'Birthday', 'id'=>'birthday', 'required'=>'required' ])}}--}}
                </div>


                <div class="form-group col-md-3">
                    {{Form::label('civil_status','Civil Status:')}}<span><sup style="color: red; font-weight: bold">*</sup></span>
                    {{ Form::select('civil_status',
                            array(
                             '1' => 'Single',
                             '2' => 'Married',
                             '3' => 'Widowed',
                             '4' => 'Separated',
                             '5' => 'Divorced'), '',
                             [  'id'                            => 'civil_status',
                                'name'                            => 'civil_status',
                                'placeholder' => '-- pls enter Civil Status --',
                                'class'                         => 'js-basic-single form-control',
                                'data-parsley-trigger'          => 'keyup change focusout',
                                'data-parsley-class-handler'    => '#civil_status-group',
                                'required'=>'required' ]
                            )}}
                </div>
                <div class="form-group col-sm-3">
                    {{Form::label('email','Email:')}}<span><sup style="color: red; font-weight: bold">*</sup></span>
                    {{Form::email('email','',['class'=>'form-control', 'placeholder'=>'-- pls enter Email --', 'required'=>'required' ])}}
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-3">
                    {{Form::label('mobile_no','Mobile No(s):')}}<span><sup style="color: red; font-weight: bold">*</sup></span>
                    {{Form::text('mobile_no','',['class'=>'form-control', 'placeholder'=>'-- pls enter Mobile No --', 'required'=>'required' ])}}
                </div>
                <div class="form-group col-sm-3">
                    {{Form::label('telno','Tel No./Land Line No(s):')}}
                    {{Form::text('telno','',['class'=>'form-control', 'placeholder'=>'-- pls enter Tel/Land Line No.--'])}}
                </div>
                <div class="form-group col-sm-3">
                    {{Form::label('ID_presented','ID presented:')}}<span><sup style="color: red; font-weight: bold">*</sup></span>
                    {!! Form::select('ID_presented',$identification_cards, '', ['class' => 'js-basic-single form-control', 'style'=>'width: 100%', 'placeholder'=>'-- pls select Valid ID --', 'required'=>'required' ]) !!}
                </div>
                <div class="form-group col-sm-3">
                    {{Form::label('ID_no','ID No:')}}<span><sup style="color: red; font-weight: bold">*</sup></span>
                    {{Form::text('ID_no','',['class'=>'form-control', 'placeholder'=>'-- pls enter ID No --', 'required'=>'required' ])}}
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-3">
                    {{Form::label('nationality','Nationality:')}}<span><sup style="color: red; font-weight: bold">*</sup></span>
                    {!! Form::select('nationality', $nationality_list,'77',['class' => 'js-basic-single form-control', 'style'=>'width: 100%', 'placeholder'=>'-- pls enter Nationality --', 'required'=>'required' ]) !!}
                </div>

                <div class="form-group col-sm-3">
                    {{Form::label('country','Country:')}}<span><sup style="color: red; font-weight: bold">*</sup></span>
                    {!! Form::select('country',$country, 'PH', ['class' => 'js-basic-single form-control', 'style'=>'width: 100%', 'placeholder'=>'-- pls enter Country --', 'required'=>'required' ]) !!}
                </div>
                <div class="form-group col-md-3">
                    {{Form::label('province','Province:')}}
                    <select id="employeeProvince" name="province_c" class="js-basic-single form-control">
                        <option value="0" disabled selected="true">-- Select Province --</option>
                        @foreach($provinceList as $prov)
                            <option value="{{$prov->PROVINCE_C}}">{{$prov->PROVINCE}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    {{Form::label('Citymun','City/Municipality:')}}<span><sup style="color: red; font-weight: bold">*</sup></span>
                    <select id="employeeCityMunicipality" name="citymun_id" class="js-basic-single form-control" required>
                        <option value="" disabled selected="true">-- Select CityMunicipality --</option>
                        @foreach($cityMunicipalityList as $cityMun)
                            <option value="{{$cityMun->CITYMUN_C}}" >{{$cityMun->CITYMUN .", ". $cityMun->PROVINCE }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">

                <div class="form-group col-md-3">
                    {{Form::label('barangay','Barangay:')}}
                    <select id="employeeBarangay" name="employeeBarangay" class="js-basic-single form-control">
                        <option value="0" disabled selected="true">-- Select Barangay --</option>
                        @foreach($barangayList as $barangay)
                            <option value="{{$barangay->BARANGAY_C}}">{{$barangay->BARANGAY}}</option>
                        @endforeach
                    </select>
                </div>

                <input type="hidden" id="uBarangay" name="uBarangay">
                <input type="hidden" id="uRegion" name="uRegion" value="">
                <input type="hidden" id="uProvince" name="uProvince" value="">
                <input type="hidden" id="uCityMunicipality" name="uCityMunicipality" value="">

                <div class="form-group col-md-9">
                    {{Form::label('address_details','House/Unit #, Street, Village/Subdivision:')}}
                    {{Form::text('address_details','',['class'=>'form-control', 'id'=>'address_details', 'placeholder'=>'-- pls enter House/Unit #, Street, Village/Subdivision --'])}}
                </div>
            </div>
            <div class="row">

                <label for="foreigner" class="col-sm-2 col-form-label">{{ __('Foreigner:') }}</label>
                <div class="col-sm-1">
                    <input id="foreigner" type="checkbox" class="form-control" name="foreigner" value = "0">
                </div>

                <div class="form-group col-sm-6">
                    {{Form::label('house_bldg_apartment_no_abroad','House No./Bldg/Apartment No. abroad:')}}
                    {{Form::text('house_bldg_apartment_no_abroad','',['class'=>'form-control', 'placeholder'=>'-- pls enter House No./Bldg/Apartment No. abroad --'])}}
                </div>

                <div class="form-group col-sm-3">
                    {{Form::label('city_muni_state_abroad','City/Municipality/State abroad:')}}
                    {{Form::text('city_muni_state_abroad','',['class'=>'form-control', 'placeholder'=>'-- pls enter City/Municipality/State abroad --'])}}
                </div>

            </div>
            <div class="row">
                <div class="form-group col-md-3">
                    <label>Account Status:</label>
                    <select name="status" id="status" class="js-basic-single form-control {{ $errors->has('status') ? ' is-invalid' : '' }}" required>
                        <option value="1" >Active</option>
                        <option value="2" >For Activation</option>
                    </select>
                    @if ($errors->has('status'))
                        <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('status') }}</strong></span>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="form-group col-sm-4">
                    <small>Employee Picture:</small>
                    <div class="form-group">
                        {{Form::file('avatar')}}
                    </div>
                </div>
                <div class="form-group col-sm-4">
                    <small>Attachment 1:</small>
                    <div class="form-group">
                        {{Form::file('attachment')}}
                    </div>
                </div>
                <div class="form-group col-sm-4">
                    <small>Attachment 2:</small>
                    <div class="form-group">
                        {{Form::file('attachment2')}}
                    </div>
                </div>
            </div>

        {{Form::submit('Submit',['class'=>'btn btn-primary'])}}
        {!! Form::close() !!}
            <!--end: Datatable -->
        </div>
    </div>

@endsection

@section('modal')

@endsection

@section('scripts')
    <script>
        $(function () {
            $("#birthday").datepicker({
                format: 'mm/dd/yyyy',
                autoclose: true,
                todayHighlight: true
            }).datepicker();
        });

        $(function () {
            $("#birthday_tester").datepicker({
                format: 'mm/dd/yyyy',
                autoclose: true,
                todayHighlight: true
            }).datepicker('update', new Date());
        });

        $(document).ready(function() {

            $('.js-basic-single').select2();


            // ---------- Changing Region that changesTblprovincevince Listing (filtered by Region)
            $(document).on('change', '#employeeRegion', function () {


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

                        $('#employeeProvince').html(" ");
                        $('#employeeProvince').html(op);

                        $('#uProvince').val(0);
                        $("#uCityMunicipality").val(0);

                    },
                    error: function () {
                    }
                });
            });

            // ---------- On ChangTblprovincevince will change the CityMunicipalTblcityMun down list
            $(document).on('change', '#employeeProvince', function () {
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

                        $('#employeeCityMunicipality').html(" ");
                        $('#employeeCityMunicipality').append(op);

                        $("#uCityMunicipality").val(0);

                        $("#uRegion").val(data[0].REGION_C);

                    },
                    error: function () {

                    }
                });
            });

            $(document).on('click','#foreigner',function(){
                if ($("#foreigner").val() == 1) {
                    $("#foreigner").val(0);
                } else {
                    $("#foreigner").val(1);
                }
            });

            $(document).on('change', '#employeeCityMunicipality', function () {

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

                        $('#employeeBarangay').html(" ");
                        $('#employeeBarangay').append(op);

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
