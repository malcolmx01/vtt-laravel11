<x-base-layout>

    <!--begin::Card-->
    <div class="card card-p-35 card-flush">

        <!--begin::card-header-->
        <div class="card-header align-items-center gap-2 gap-md-5 pt-15 px-10 pt-lg-15 px-lg-15">

            <!--begin::card-title-->
            <h3 class="card-title">Page Title</h3>
            <!--end::card-title-->

            <!--begin::card-toolbar-->
            <div class="card-toolbar flex-row-fluid justify-content-end gap-5">

                <!--begin::Menu-->
                <a href="#" class="btn btn-brand btn-elevate btn-icon-sm"><i class="la la-plus"></i> Add </a>
                <!--end::Menu-->

            </div>
            <!--end::card-toolbar-->

        </div>
        <!--end::card-header-->

        <!--begin::card-body-->
        <div class="card-body pe-15 px-10 pe-lg-15 px-lg-15">

            <!--begin::Table container-->
            <div class="table-responsive">

                {{--{{$dataTable->table()}}--}}

            </div>
            <!--end::Table container-->

            <div class="container mt-5">
                <h2 class="mb-4">Laravel 7|8 Yajra Datatables Example</h2>
                <table class="table table-bordered yajra-datatable">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

        </div>
        <!--end::card-body-->

    </div>
    <!--end::Card-->

    <!--begin::Slot for Styles-->
    <x-slot name="styles">
        {{--<link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">--}}
        {{--<link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">--}}
        <link href="{{asset('demo1/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css"/>
        <style type="text/css">
            #kt_datatable_example_1_filter{
                display:none;
            }
        </style>
    </x-slot>
    <!--end::Slot for Styles-->

    <!--begin::Scripts-->
    <x-slot name="scripts">
        <script src="{{asset('demo1/plugins/custom/datatables/datatables.bundle.js')}}"></script>
        {{--{{$dataTable->scripts()}}--}}
        {{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>--}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
        <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
        {{--<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>--}}
        <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
        <script type="text/javascript">
            $(function () {

                var table = $('.yajra-datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('ber.lis') }}",
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'category', name: 'Category', searchable: true, orderable: true},
                        {data: 'description', name: 'Description', searchable: true, orderable: true},
                        {
                            data: 'action',
                            name: 'action',
                            orderable: true,
                            searchable: true
                        },
                    ]
                });

            });
        </script>
    </x-slot>
    <!--end::Scripts-->

</x-base-layout>
