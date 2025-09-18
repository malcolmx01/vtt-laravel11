<div>

    <!-- ********************************************************************************** -->
    <!-- *** Start: Message Box -->
    <!-- ********************************************************************************** -->
    @include('livewire.components.notification')

    <!-- ********************************************************************************** -->
    <!-- *** End: Message Box -->
    <!-- ********************************************************************************** -->

    <div class="card card-p-35 card-flush">

        <!--begin::card-header-->
        <div class="card-header align-items-center gap-2 gap-md-5 pt-15 px-10 pt-lg-15 px-lg-15">
            <!--begin::card-title-->
            <h3 class="card-title">List of Downloadable Reports</h3>
            <!--end::card-title-->
        </div>
        <!--end::card-header-->

        <!--begin::card-body-->
        <div class="card-body pe-15 px-10 pe-lg-15 px-lg-15">
            <!--begin::Table container-->
            <div class="table-responsive">
                {{--<table class="table table-striped border rounded gy-5 gs-7">--}}
                <table class="table table-row-dashed table-row-gray-200 align-middle gs-7 gy-4">
                    <thead>
                    <tr class="fw-bolder fs-6 text-gray-900">
                        <th nowrap>#</th>
                        <th nowrap>Name</th>
                        <th nowrap class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Bureau Order</td>
                            <td class="text-center" nowrap="nowrap">
                                <div class="d-flex justify-content-center flex-shrink-0">
                                    <a class="btn btn-icon btn-light-success btn-sm me-1">
                                        <i class="las la-file-excel fs-2"></i>
                                    </a>
                                    <a class="btn btn-icon btn-light-danger btn-sm me-1">
                                        <i class="las la-file-pdf fs-2"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Department Order</td>
                            <td class="text-center" nowrap="nowrap">
                                <div class="d-flex justify-content-center flex-shrink-0">
                                    <a class="btn btn-icon btn-light-success btn-sm me-1">
                                        <i class="las la-file-excel fs-2"></i>
                                    </a>
                                    <a class="btn btn-icon btn-light-danger btn-sm me-1">
                                        <i class="las la-file-pdf fs-2"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Circulars</td>
                            <td class="text-center" nowrap="nowrap">
                                <div class="d-flex justify-content-center flex-shrink-0">
                                    <a class="btn btn-icon btn-light-success btn-sm me-1">
                                        <i class="las la-file-excel fs-2"></i>
                                    </a>
                                    <a class="btn btn-icon btn-light-danger btn-sm me-1">
                                        <i class="las la-file-pdf fs-2"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Memoranda</td>
                            <td class="text-center" nowrap="nowrap">
                                <div class="d-flex justify-content-center flex-shrink-0">
                                    <a class="btn btn-icon btn-light-success btn-sm me-1">
                                        <i class="las la-file-excel fs-2"></i>
                                    </a>
                                    <a class="btn btn-icon btn-light-danger btn-sm me-1">
                                        <i class="las la-file-pdf fs-2"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Others</td>
                            <td class="text-center" nowrap="nowrap">
                                <div class="d-flex justify-content-center flex-shrink-0">
                                    <a class="btn btn-icon btn-light-success btn-sm me-1">
                                        <i class="las la-file-excel fs-2"></i>
                                    </a>
                                    <a class="btn btn-icon btn-light-danger btn-sm me-1">
                                        <i class="las la-file-pdf fs-2"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!--end::Table container-->
        </div>
        <!--end::card-body-->

    </div>


    <!--begin::Slot for Styles-->
    <x-slot name="styles">
        <style>
            .pagination{
                justify-content: unset !important;
            }
        </style>
    </x-slot>
    <!--end::Slot for Styles-->

</div>


{{-- begin::Inject Scripts using @section --}}
@section('scripts')
    <script type="text/javascript">

    </script>
@endsection
{{-- end::Inject Scripts using @section --}}

