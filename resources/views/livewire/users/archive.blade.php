<div class="card card-p-35 card-flush">

    <!--begin::card-header-->
    <div class="card-header align-items-center gap-2 gap-md-5 pt-15 px-10 pt-lg-15 px-lg-15">
        <!--begin::card-title-->
        <h3 class="card-title">Users Archive</h3>
        <!--end::card-title-->

        <!--begin::card-toolbar-->
        <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
            <!--begin::Wrapper-->
            <div data-bs-toggle="tooltip" data-bs-placement="left" data-bs-trigger="hover" title="Create New Item">
                <!--begin::Menu-->
                <a wire:click="create" class="btn btn-primary fw-bolder btn-brand btn-elevate btn-icon-sm"  data-bs-toggle="modal" data-bs-target="#formCreateModal"><i class="la la-plus"></i> Add </a>
                <!--end::Menu-->
            </div>
            <!--end::Wrapper-->

            <!--begin::Menu-->
            <!--begin::Export dropdown-->
            <button type="button" class="btn btn-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                <!--begin::Svg Icon | path: icons/duotune/arrows/arr078.svg-->
                <span class="svg-icon svg-icon-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <rect opacity="0.3" x="12.75" y="4.25" width="12" height="2" rx="1" transform="rotate(90 12.75 4.25)" fill="black"></rect>
                        <path d="M12.0573 6.11875L13.5203 7.87435C13.9121 8.34457 14.6232 8.37683 15.056 7.94401C15.4457 7.5543 15.4641 6.92836 15.0979 6.51643L12.4974 3.59084C12.0996 3.14332 11.4004 3.14332 11.0026 3.59084L8.40206 6.51643C8.0359 6.92836 8.0543 7.5543 8.44401 7.94401C8.87683 8.37683 9.58785 8.34458 9.9797 7.87435L11.4427 6.11875C11.6026 5.92684 11.8974 5.92684 12.0573 6.11875Z" fill="black"></path>
                        <path d="M18.75 8.25H17.75C17.1977 8.25 16.75 8.69772 16.75 9.25C16.75 9.80228 17.1977 10.25 17.75 10.25C18.3023 10.25 18.75 10.6977 18.75 11.25V18.25C18.75 18.8023 18.3023 19.25 17.75 19.25H5.75C5.19772 19.25 4.75 18.8023 4.75 18.25V11.25C4.75 10.6977 5.19771 10.25 5.75 10.25C6.30229 10.25 6.75 9.80228 6.75 9.25C6.75 8.69772 6.30229 8.25 5.75 8.25H4.75C3.64543 8.25 2.75 9.14543 2.75 10.25V19.25C2.75 20.3546 3.64543 21.25 4.75 21.25H18.75C19.8546 21.25 20.75 20.3546 20.75 19.25V10.25C20.75 9.14543 19.8546 8.25 18.75 8.25Z" fill="#C4C4C4"></path>
                    </svg>
                </span>
                <!--end::Svg Icon-->
                Export Report
            </button>
            <div id="kt_datatable_example_1_export_menu" class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-200px py-4" data-kt-menu="true">
                <!--begin::Menu item-->
                <div class="menu-item px-3">
                    <a href="#" class="menu-link px-3" data-kt-export="copy">
                        Copy to clipboard
                    </a>
                </div>
                <!--end::Menu item-->
                <!--begin::Menu item-->
                <div class="menu-item px-3">
                    <a wire:click="downloadExcel" class="menu-link px-3" data-kt-export="excel">
                        Export as Excel
                    </a>
                </div>
                <!--end::Menu item-->
                <!--begin::Menu item-->
                <div class="menu-item px-3">
                    <a href="#" class="menu-link px-3" data-kt-export="csv">
                        Export as CSV
                    </a>
                </div>
                <!--end::Menu item-->
                <!--begin::Menu item-->
                <div class="menu-item px-3">
                    <a href="#" class="menu-link px-3" data-kt-export="pdf">
                        Export as PDF
                    </a>
                </div>
                <!--end::Menu item-->
            </div>
            <!--end::Export dropdown-->
            <!--end::Menu-->

            <div @if (!$checked) class="d-none" @endif>
                <a href="#" class="btn btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
                    With Checked ({{ count($checked) }}) <span class="svg-icon svg-icon-5 m-0"> <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"> <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <polygon points="0 0 24 0 24 24 0 24"></polygon> <path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000003, 11.999999) rotate(-180.000000) translate(-12.000003, -11.999999)"></path> </g> </svg> </span>
                </a>
                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-200px py-4" data-kt-menu="true" style="">

                    <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3" type="button"
                           onclick="confirm('Are you sure you want to delete these Records?') || event.stopImmediatePropagation()"
                           wire:click="deleteRecords()">
                            <i class="las la-trash-alt"></i> Delete
                        </a>
                    </div>
                    <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3" type="button"
                           onclick="confirm('Are you sure you want to export these Records?') || event.stopImmediatePropagation()"
                           wire:click="exportSelected()">
                            Export
                        </a>
                    </div>
                </div>
            </div>

        </div>
        <!--end::card-toolbar-->
    </div>
    <!--end::card-header-->

    <!--begin::card-body-->
    <div class="card-body pe-15 px-10 pe-lg-15 px-lg-15">

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
                    <button wire:click="$set('search', '')" class="input-group-text btn btn-light" type="button" id="button-addon2"><i class="las la-times"></i></button>
                </div>
            </div>

            <div class="col-md-4">
                <div class="input-group input-group-solid mb-5">
                    <span class="input-group-text">Sort By</span>
                    <select wire:model="orderBy" class="form-select form-select-solid"  id="orderBy">
                        <option value="id">ID</option>
                        <option value="first_name">First Name</option>
                        <option value="last_name">Last Name</option>
                        <option value="email">email</option>
                        <option value="status">Status</option>
                        <option value="created_at">Created Date</option>
                    </select>
                    <select wire:model="orderAsc" class="form-select form-select-solid" id="orderBy">
                        <option value="0">desc</option>
                        <option value="1">asc</option>
                    </select>
                </div>
            </div>
        </div>

        <!--begin::Table container-->
        <div class="table-responsive">
            <table class="table table-row-dashed table-row-gray-200 align-middle gs-7 gy-4">
                <thead>
                <tr class="fw-bolder fs-6 text-gray-900">
                    <th nowrap></th>
                    <th nowrap>#</th>
                    <th nowrap>Photo</th>
                    <th nowrap>First Name</th>
                    <th nowrap>Last Name</th>
                    <th nowrap>email</th>
                    <th nowrap>Status</th>
                    <th nowrap class="text-center">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($users as $usersRow)
                    <tr wire:key="{{ $loop->index }}">
                        <td>
                            <div class="form-check form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="{{ $usersRow->id }}" wire:model="checked" />
                            </div>
                        </td>
                        <td>{{ (($users->currentPage() * $users->perPage()) - $users->perPage()) + $loop->iteration }}</td>
                        <td>
                            @if(!empty($usersRow->info->avatar) && (file_exists(public_path('storage/'.$usersRow->info->avatar)) || file_exists(public_path('storage/'.$usersRow->info->avatar))))
                                @if(file_exists(public_path('storage/'.$usersRow->info->avatar)))
                                    <img src="{{ asset('storage/'.$usersRow->info->avatar) }}" style="object-fit: cover; border: 1px solid #f5f5f5; border-radius: 4px; width: 60px; height: 40px;" />
                                @elseif(file_exists(public_path('storage/'.$usersRow->info->avatar)))
                                    <img src="{{ asset('storage/'.$usersRow->info->avatar) }}" style="object-fit: cover; border: 1px solid #f5f5f5; border-radius: 4px; width: 60px; height: 40px;" />
                                @endif
                            @else
                                <img src="{{ asset('storage/no_image-orig.jpg') }}" style="object-fit: cover; border-radius: 4px; width: 60px; height: 40px;" />
                            @endif
                        </td>
                        <td class="text-break">{{ $usersRow->first_name }}</td>
                        <td class="text-break">{{ $usersRow->last_name }}</td>
                        <td class="text-break">{{ $usersRow->email }}</td>
                        <td>
                            @if($usersRow->approved == 1)
                                <span class="badge badge-success">Active</span>
                            @elseif($usersRow->approved == 0)
                                <span class="badge badge-secondary">Inactive</span>
                            @endif
                        </td>
                        <td class="text-end" nowrap="nowrap">
                            <div class="d-flex justify-content-end flex-shrink-0">
                                <a wire:click="show({{$usersRow->id}})" title="Show Details for ({{ $usersRow->first_name }}. .{{ $usersRow->last_name }})"  data-bs-toggle="modal" data-bs-target="#formShowModal" data-bs-dismiss="modal" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                    <!--begin::Svg Icon | path: assets/media/icons/duotune/general/gen004.svg-->
                                    <span class="svg-icon svg-icon-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M21.7 18.9L18.6 15.8C17.9 16.9 16.9 17.9 15.8 18.6L18.9 21.7C19.3 22.1 19.9 22.1 20.3 21.7L21.7 20.3C22.1 19.9 22.1 19.3 21.7 18.9Z" fill="currentColor"/>
                                                <path opacity="0.3" d="M11 20C6 20 2 16 2 11C2 6 6 2 11 2C16 2 20 6 20 11C20 16 16 20 11 20ZM11 4C7.1 4 4 7.1 4 11C4 14.9 7.1 18 11 18C14.9 18 18 14.9 18 11C18 7.1 14.9 4 11 4ZM8 11C8 9.3 9.3 8 11 8C11.6 8 12 7.6 12 7C12 6.4 11.6 6 11 6C8.2 6 6 8.2 6 11C6 11.6 6.4 12 7 12C7.6 12 8 11.6 8 11Z" fill="currentColor"/>
                                            </svg>
                                        </span>
                                    <!--end::Svg Icon-->
                                </a>
                                <a wire:click="edit({{$usersRow->id}})" title="Show Details for ({{ $usersRow->first_name }}. .{{ $usersRow->last_name }})"    data-bs-toggle="modal" data-bs-target="#formUpdateModal" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                    <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                    <span class="svg-icon svg-icon-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="currentColor"></path>
                                                <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="currentColor"></path>
                                            </svg>
                                        </span>
                                    <!--end::Svg Icon-->
                                </a>
                                <a href="{{ route('admin.users.show', $usersRow->id) }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                    <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/metronic/releases/2022-07-05-142712/core/html/src/media/icons/duotune/coding/cod001.svg-->
                                    <span class="svg-icon svg-icon-3"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path opacity="0.3" d="M22.1 11.5V12.6C22.1 13.2 21.7 13.6 21.2 13.7L19.9 13.9C19.7 14.7 19.4 15.5 18.9 16.2L19.7 17.2999C20 17.6999 20 18.3999 19.6 18.7999L18.8 19.6C18.4 20 17.8 20 17.3 19.7L16.2 18.9C15.5 19.3 14.7 19.7 13.9 19.9L13.7 21.2C13.6 21.7 13.1 22.1 12.6 22.1H11.5C10.9 22.1 10.5 21.7 10.4 21.2L10.2 19.9C9.4 19.7 8.6 19.4 7.9 18.9L6.8 19.7C6.4 20 5.7 20 5.3 19.6L4.5 18.7999C4.1 18.3999 4.1 17.7999 4.4 17.2999L5.2 16.2C4.8 15.5 4.4 14.7 4.2 13.9L2.9 13.7C2.4 13.6 2 13.1 2 12.6V11.5C2 10.9 2.4 10.5 2.9 10.4L4.2 10.2C4.4 9.39995 4.7 8.60002 5.2 7.90002L4.4 6.79993C4.1 6.39993 4.1 5.69993 4.5 5.29993L5.3 4.5C5.7 4.1 6.3 4.10002 6.8 4.40002L7.9 5.19995C8.6 4.79995 9.4 4.39995 10.2 4.19995L10.4 2.90002C10.5 2.40002 11 2 11.5 2H12.6C13.2 2 13.6 2.40002 13.7 2.90002L13.9 4.19995C14.7 4.39995 15.5 4.69995 16.2 5.19995L17.3 4.40002C17.7 4.10002 18.4 4.1 18.8 4.5L19.6 5.29993C20 5.69993 20 6.29993 19.7 6.79993L18.9 7.90002C19.3 8.60002 19.7 9.39995 19.9 10.2L21.2 10.4C21.7 10.5 22.1 11 22.1 11.5ZM12.1 8.59998C10.2 8.59998 8.6 10.2 8.6 12.1C8.6 14 10.2 15.6 12.1 15.6C14 15.6 15.6 14 15.6 12.1C15.6 10.2 14 8.59998 12.1 8.59998Z" fill="currentColor"/>
<path d="M17.1 12.1C17.1 14.9 14.9 17.1 12.1 17.1C9.30001 17.1 7.10001 14.9 7.10001 12.1C7.10001 9.29998 9.30001 7.09998 12.1 7.09998C14.9 7.09998 17.1 9.29998 17.1 12.1ZM12.1 10.1C11 10.1 10.1 11 10.1 12.1C10.1 13.2 11 14.1 12.1 14.1C13.2 14.1 14.1 13.2 14.1 12.1C14.1 11 13.2 10.1 12.1 10.1Z" fill="currentColor"/>
</svg>
</span>
                                    <!--end::Svg Icon-->
                                </a>
                                <a wire:click="deleteId({{ $usersRow->id }})" title="Delete User - ({{ $usersRow->first_name ." ". $usersRow->last_name}})"  data-bs-toggle="modal" data-bs-target="#deleteModalConfirmation" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
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
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!--end::Table container-->
        <!-- begin::Pagination -->
        <div class="row">
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
                <div class="dataTables_info" role="status" aria-live="polite">Showing {{$users->firstItem()}} to {{$users->lastItem()}} out of {{$users->total()}} records</div>
            </div>
            <div class="col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end">
                <div class="dataTables_paginate paging_simple_numbers">
                    {!! $users->links() !!}
                </div>
            </div>
        </div>
        <!-- end::Pagination -->
    </div>
    <!--end::card-body-->

</div>


<!-- Delete Modal -->
<div wire:ignore.self class="modal fade" tabindex="-1" id="deleteModalConfirmation">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Confirmation</h5>
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                    <span class="svg-icon svg-icon-2x">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black"></rect>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black"></rect>
                            </svg>
                        </span>
                    <!--end::Svg Icon-->
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
                <p>Are you sure want to delete <strong>{{ $deletedRow ? $deletedRow->first_name ." ". $deletedRow->last_name.'?' : '' }} ?</strong></p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button wire:click="delete" type="button" class="btn btn-danger" data-bs-dismiss="modal">Yes, Delete</button>
            </div>
        </div>
    </div>
</div>
