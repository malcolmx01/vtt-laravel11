@section('pageTitle','Title Page')
@section('pageDescription','Text Description')

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

                <!--begin::Table-->
                <table class="table table-striped border rounded gy-5 gs-7" id="kt_datatable_example_1">
                    <!--begin::Table head-->
                    <thead>
                    <tr class="fw-bolder fs-6 text-gray-900">
                        <th>ID</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Date Created</th>
                        <th>User ID</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody>
                    @foreach ($categories as $categoriesList)
                        <tr>
                            <td>{{$categoriesList->id}}</td>
                            <td>{{$categoriesList->category}}</td>
                            <td>
                                {{$categoriesList->description}}
                            </td>
                            <td>
                                @switch($categoriesList->status)
                                    @case(0)
                                    <span class="badge badge-light-danger">Inactive</span>
                                    @break
                                    @case(1)
                                    <span class="badge badge-light-success">Active</span>
                                    @break
                                    @case(2)
                                    <span class="bbadge badge-light-warning">Disapproved</span>
                                    @break
                                    @default
                                    <span class="badge badge-light-danger">Pendings</span>
                                @endswitch
                            </td>
                            <td>{{$categoriesList->created_at}}</td>
                            <td>{{$categoriesList->user_id}}</td>
                            <td>
                                <a href="{{route('categories.show', $categoriesList->id)}}" class="btn btn-sm btn-bg-light btn-active-color-info py-2 px-2" title="Show details">
                                    <i class="la la-eye" style="font-size: 22px !important;" ></i>
                                </a>
                                <a href="{{route('categories.edit', $categoriesList->id)}}" class="btn btn-sm btn-bg-light btn-active-color-info y-2 px-2" title="Edit details">
                                    <i class="la la-pencil" style="font-size: 22px !important;" ></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <!--end::Table body-->
                </table>
                <!--end::Table-->

            </div>
            <!--end::Table container-->

        </div>
        <!--end::card-body-->

    </div>
    <!--end::Card-->

    <!--begin::Slot for Styles-->
    <x-slot name="styles">
        <link href="{{asset('demo1/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css"/>
    </x-slot>
    <!--end::Slot for Styles-->

    <!--begin::Modal-->
    <x-slot name="modal">

    </x-slot>
    <!--end::Modal-->

    <!--begin::Scripts-->
    <x-slot name="scripts">

    </x-slot>
    <!--end::Scripts-->

    {{-- begin::Inject Scripts using @section --}}
    @section('scripts')

    @endsection
    {{-- end::Inject Scripts using @section --}}


</x-base-layout>
