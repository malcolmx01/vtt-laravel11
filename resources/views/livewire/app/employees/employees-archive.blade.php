<div>
    <!-- ********************************************************************************** -->
    <!-- *** Start: Modal Archive -->
    <!-- ********************************************************************************** -->
    <div wire:ignore.self class="modal fade bg-opacity-50 bg-dark" id="ListOfEmployeeModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-primary modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModalLabel">Archive | <span class="text-muted fw-normal">Employees</span></h5>
                    <div>
                        <!--begin::maximize-->
                        {{--<div class="btn btn-icon btn-sm btn-active-light-primary ms-2">--}}
                            <a class="btn btn-primary fw-bolder btn-brand btn-elevate btn-icon-sm" wire:click="create()"><i class="la la-plus"></i> Add </a>
                        {{--</div>--}}
                        <!--end::maximize-->
                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <span class="svg-icon svg-icon-2x">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black"></rect>
                                    <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black"></rect>
                                </svg>
                            </span>
                        </div>
                        <!--end::Close-->
                    </div>
                </div>

                <div class="modal-body">
                    <!-- ********************************************************************************** -->
                    <!-- *** Start: Module Archive -->
                    <!-- ********************************************************************************** -->
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <div class="input-group input-group-solid mb-5">
                                        <span class="input-group-text" id="search">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black"/>
                                                <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black"/>
                                            </svg>
                                        </span>
                                <input wire:model.debounce.300ms="search" class="form-control" type="text"  placeholder="search" aria-label="search" aria-describedby="search"/>
                                @if(!empty($search))
                                    <button wire:click="$set('search', '')" class="input-group-text btn btn-light" type="button" id="button-addon2"><i class="las la-times"></i></button>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group input-group-solid mb-5">
                                <span class="input-group-text">Sort By</span>
                                <select wire:model="orderBy" class="form-select form-select-solid"  id="orderBy">
                                    <option value="id">ID</option>
                                    <option value="employee_no">Employee No.</option>
                                    <option value="first_name">First Name</option>
                                    <option value="middle_name">Middle Name</option>
                                    <option value="last_name">Last Name</option>
                                    {{--<option value="birthday">Birthday</option>--}}
                                    {{--<option value="sex">Sex</option>--}}
                                    {{--<option value="email">Email</option>--}}
                                    {{--<option value="mobile_nos">Mobile No.</option>--}}
                                    <option value="department">Department</option>
                                    <option value="position">Position</option>
                                    <option value="created_at">Date Created</option>
                                </select>
                                <select wire:model="orderAsc" class="form-select form-select-solid" id="orderBy">
                                    <option value="0">desc</option>
                                    <option value="1">asc</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-5 shadow-sm">
                        <!--begin::card-body-->
                        <div class="card-body pt-10">
                            <!--begin::Table container-->
                            <div class="table-responsive">
                                <table class="table table-row-dashed table-row-gray-200 align-middle gs-7 gy-4">
                                    <thead>
                                    <tr class="fw-bolder fs-6 text-gray-900">
                                        <th nowrap>#</th>
                                        <th nowrap>Employee No.</th>

                                        <th nowrap>First Name</th>
                                        <th nowrap>Middle Name</th>
                                        <th nowrap>Last Name</th>

                                        <th nowrap>Position</th>
                                        <th nowrap>Department</th>
                                        {{--<th nowrap>Sex</th>--}}

                                        {{--<th nowrap>Birthday</th>--}}
                                        {{--<th nowrap>Email</th>--}}
                                        {{--<th nowrap>Mobile No.</th>--}}

                                        <th nowrap class="text-center">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($employees as $data)

                                        <tr wire:key="{{ $loop->index }}">
                                            <th>{{ (($employees->currentPage() * $employees->perPage()) - $employees->perPage()) + $loop->iteration }} {{--  $categoryRow->classification()->count() --}}</th>
                                            <td nowrap>{{ $data->employee_no }}</td>

                                            <td nowrap>{{ $data->first_name }}</td>
                                            <td nowrap>{{ $data->middle_name }}</td>
                                            <td nowrap>{{ $data->last_name }}</td>

                                            <td nowrap>{{ $data->position }}</td>
                                            <td nowrap>{{ $data->department }}</td>
                                            {{--<td nowrap>{{ $data->sex }}</td>--}}

                                            {{--<td nowrap>{{ $data->birthday ? \Carbon\Carbon::parse($data->birthday)->format('M d, Y') : '' }}</td>--}}
                                            {{--<td nowrap>{{ $data->email }}</td>--}}
                                            {{--<td nowrap>{{ $data->mobile_nos }}</td>--}}

                                            <td class="text-end" nowrap="nowrap">
                                                <div class="d-flex justify-content-end flex-shrink-0">
                                                    <a wire:click="show({{$data->id}})" title="Show more details" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                        <!--begin::Svg Icon | path: assets/media/icons/duotune/general/gen004.svg-->
                                                        <span class="svg-icon svg-icon-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M21.7 18.9L18.6 15.8C17.9 16.9 16.9 17.9 15.8 18.6L18.9 21.7C19.3 22.1 19.9 22.1 20.3 21.7L21.7 20.3C22.1 19.9 22.1 19.3 21.7 18.9Z" fill="currentColor"/>
                                                <path opacity="0.3" d="M11 20C6 20 2 16 2 11C2 6 6 2 11 2C16 2 20 6 20 11C20 16 16 20 11 20ZM11 4C7.1 4 4 7.1 4 11C4 14.9 7.1 18 11 18C14.9 18 18 14.9 18 11C18 7.1 14.9 4 11 4ZM8 11C8 9.3 9.3 8 11 8C11.6 8 12 7.6 12 7C12 6.4 11.6 6 11 6C8.2 6 6 8.2 6 11C6 11.6 6.4 12 7 12C7.6 12 8 11.6 8 11Z" fill="currentColor"/>
                                            </svg>
                                        </span>
                                                        <!--end::Svg Icon-->
                                                    </a>
                                                    <a wire:click="edit({{$data->id}})" title="Edit details"  class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                        <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                                        <span class="svg-icon svg-icon-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="currentColor"></path>
                                                <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="currentColor"></path>
                                            </svg>
                                        </span>
                                                        <!--end::Svg Icon-->
                                                    </a>
                                                    <a wire:click="confirmDelete({{ $data->id }})" title="Delete this record" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
                                                        <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                                        <span class="svg-icon svg-icon-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor"></path>
                                                <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor"></path>
                                                <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor"></path>
                                            </svg>
                                        </span>
                                                        <!--end::Svg Icon-->
                                                    </a>
                                                    {{--@livewire('vtt.ris-delete', ['risheader' => $data->id], key($data->id))--}}
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!--end::Table container-->
                            <!-- begin::Pagination -->
                            <div class="row mt-5">
                                <div class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start">
                                    <div class="dataTables_length" id="kt_datatable_example_2_length"><label>
                                            <select wire:model="perPage" class="form-select form-select-sm form-select-solid"  id="perPage">
                                                <option>10</option>
                                                <option>25</option>
                                                <option>50</option>
                                                <option>100</option>
                                            </select>
                                        </label>
                                    </div>
                                    <div class="dataTables_info" role="status" aria-live="polite">Showing {{$employees->firstItem()}} to {{$employees->lastItem()}} out of {{$employees->total()}} records</div>
                                </div>
                                <div class="col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end">
                                    <div class="dataTables_paginate paging_simple_numbers">
                                        {!! $employees->links() !!}
                                    </div>
                                </div>
                            </div>
                            <!-- end::Pagination -->
                        </div>
                        <!--end::card-body-->

                    </div>
                    <!-- ********************************************************************************** -->
                    <!-- *** End: Module Archive -->
                    <!-- ********************************************************************************** -->
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- ********************************************************************************** -->
    <!-- *** End: Modal Archive -->
    <!-- ********************************************************************************** -->
</div>

{{-- begin::Inject Scripts using @section --}}
{{--@section('scripts')--}}
    {{--<script type="text/javascript">--}}

        {{--$(document).ready(function () {--}}
            {{--$( ".createEmployeeModal" ).click(function() {--}}
                {{--window.livewire.emit('CreateNewEmployeeRecord');--}}
            {{--});--}}
        {{--});--}}

        {{--window.addEventListener('openEmployeeArchiveModal', event => {--}}
            {{--$("#ListOfEmployeeModal").modal('show');--}}
        {{--});--}}
        {{--window.addEventListener('closeEmployeeArchiveModal', event => {--}}
            {{--$("#ListOfEmployeeModal").modal('hide');--}}
        {{--});--}}


    {{--</script>--}}
{{--@endsection--}}
{{-- end::Inject Scripts using @section --}}
