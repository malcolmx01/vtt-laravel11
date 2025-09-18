@extends('vtt.layouts.main')
@section('content')
    <!-- begin:: Content Head -->
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">
                    Employee Information
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

                <a href="{{route('employees.index')}}"class="btn btn-label-primary btn-icon-sm"><i aria-hidden="true" class="la la-list"></i>
                    Archive
                </a>&nbsp;

                <a href="{{route('employees.create')}}" class="btn btn-label-brand btn-elevate btn-icon-sm"><i class="la la-plus"></i>
                    Add
                </a>
                <a href="{{route('employees.edit', $employee->id)}}" class="btn btn-label-success btn-elevate btn-icon-sm"><i class="la la-edit"></i>
                    Edit
                </a>
                <button type="button" class="btn btn-label-warning btn-elevate btn-icon-sm" id="showQRCodeList" data-toggle="modal" data-target="#showQRCodeModal" onclick="showQRCode();"><i class="la la-qrcode"></i>QR Code
                </button>
            </div>
        </div>
    </div>
    <!-- end:: Content Head -->

    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <h1 >Employee Profile</h1>
        </div>
        <div class="row">
            <div class="col-md-8">
                <input type="hidden" id="employeeID" value = "{{ $employee->id }}" >
                <img src="/storage/employee_image/{{ $employee->avatar }}"  class="profile-avatar-image" />
                <span class="profile-avatar">Full Name: <b>{{ $employee->first_name }} {{ $employee->middle_name }} {{ $employee->last_name }} {{ $employee->suffix }}</b></span>
                <div>
                    Sex: <b>{{ $employee->gender }}</b>
                </div>
                <div>
                    Age: <b>{{ $employee->age }}</b>
                </div>
                <div>
                    Birthday: <span> <b>{{ date('F j, Y', strtotime($employee->birthday)) }}</b></span>
                </div>
                <div>
                    Civil Status: <span> <b>{{ $employee->civil_status }}</b></span>
                </div>
            </div>

            <div class="col-md-4">
                <div class="flaticon2-phone">
                    <span><b>{{ $employee->mobile_no }}  ,  {{ $employee->telno }}</b> </span>
                </div>
                <div class="flaticon2-email">
                    <span><b>{{ $employee->email }}</b> </span>
                </div>
                <div class="flaticon2-user">
                    <span>{{ $employee->ID_presented }} No: <b>{{ $employee->ID_no }}</b></span>
                </div>

                <div>
                    Employee Class:<span> <b>{{$employee->class}}</b></span>
                </div>
                <div>
                    Payment Mode:<span> <b>{{$employee->type_of_payment}}</b></span>
                </div>
                <div>
                    Status:<span> <b>{{ $employee->status }}</b></span>
                </div>

            </div>
        </div>
        <hr>

        <div class="row">
            <div class="col-md-8">
                <div>
                    <label>Address:</label> <span> <b> {{ $employee->address }} </b></span>
                </div>
                <div>
                    <label> Country:</label><span> <b>{{ $employee->country }}</b></span> <label></label>Nationality:</label><span> <b>{{ $employee->nationality }}</b></span>
                </div>
                <div>
                    <label>Foreigner: </label> <span><input id="foreigner" type="checkbox" name="foreigner" @if($employee->foreigner == 1 ) checked @endif disabled> </span> <label>Address Abroad:</label><span> <b>{{ $employee->address_abroad }}</b></span></b></span>
                </div>
            </div>
        </div>

        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
            <div class="kt-heading kt-heading--space-sm">Transaction Record</div>
            <!--begin::Portlet-->
            <div class="kt-portlet kt-portlet--mobile">
                <div class="kt-portlet__body kt-portlet__body--fit">
                    <!--begin: Datatable -->
                    <div class="kt-datatable" id="kt_apps_record_datatable"></div>
                    <!--end: Datatable -->
                </div>
            </div>
            <!--end::Portlet-->
        </div>

        <div class="row">
            <div class="col-sm-3">
                <img style="width:90%; height:50%" src="/storage/employee_image/{{$employee->attachment}}">
                <small>Attachment 1: {{$employee->attachment}}</small>
            </div>
            <div class="col-sm-6">
            </div>
            <div class="col-sm-3">
                <img style="width:90%; height:50%" src="/storage/employee_image/{{$employee->attachment2}}">
                <small>Attachment 2: {{$employee->attachment2}}</small>
            </div>
        </div>


        <div class="row">
            <div class="form-group col-md-12">
                <small> Written on {{$employee->created_at}} by: {{$employee->user_id}}</small>
            </div>
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
                                Are you sure, you want to permanently delete Profile No. :<strong class="post-record-id">.</strong><br/><br/>
                                Store/Company: <strong class="post-record-title"></strong>?
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

    <!-- Show QR Modal -->
    <div id="showQRCodeModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" >
        <div class="modal-dialog" style="width:55%;">
            <div class="modal-content square shadow">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div id ="viewQRcode" class="modal-body">
                    <h5 class="modal-title" id="custom-width-modalLabel">QR Code for Employee: {{$employee->name}}</h5>
                    <div>&nbsp</div>
                    @if($employee->id == "1")
                        <img src="data:image/png;base64,{{DNS2D::getBarcodePNG(route('responder_validator', ['employee_id' => $employee->preview_id]), 'QRCODE')}}" alt="QR Code"  style="height: 200px; width: 200px;"/>
                    @else
                        @if($employee->company == "PHILMED")
                            <img src="data:image/png;base64,{{DNS2D::getBarcodePNG(route('employeesvalidator', ['employee_id' => $employee->preview_id]), 'QRCODE')}}" alt="QR Code"  style="height: 200px; width: 200px;"/>
                        @else
                            <img src="data:image/png;base64,{{DNS2D::getBarcodePNG(route('ddsv_employeesvalidator', ['employee_id' => $employee->preview_id]), 'QRCODE')}}" alt="QR Code"  style="height: 200px; width: 200px;"/>
                        @endif
                    @endif
                </div>
                <div class="modal-footer">
                    <button id="PrintQRcode" type="button" class="btn btn-sm btn-success" onclick="window.print()"><i class="fa fa-print"></i> Print</button>
                    <button type="button" class="btn btn-sm btn-default waves-effect remove-data-from-delete-form" data-dismiss="modal"><span class="lnr-cross-circle"></span> Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <script>

        document.getElementById("PrintBarcode").onclick = function () {
            printElement(document.getElementById("viewBarcode"));
        };

        function printElement(elem) {
            var domClone = elem.cloneNode(true);

            var $printSection = document.getElementById("printSection");

            if (!$printSection) {
                var $printSection = document.createElement("div");
                $printSection.id = "printSection";
                document.body.appendChild($printSection);
            }

            $printSection.innerHTML = "";
            $printSection.appendChild(domClone);
            window.print();
        }

        document.getElementById("PrintQRcode").onclick = function () {
            printQRElement(document.getElementById("viewQRcode"));
        };

        function printQRElement(elem) {
            var domClone = elem.cloneNode(true);

            var $printSection = document.getElementById("printSection");

            if (!$printSection) {
                var $printSection = document.createElement("div");
                $printSection.id = "printSection";
                document.body.appendChild($printSection);
            }

            $printSection.innerHTML = "";
            $printSection.appendChild(domClone);
            window.print();
        }

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

        $(document).ready(function() {
            refresh_record();
        });

    </script>
@endsection
