<!-- Modal For Create-->
<div wire:ignore.self class="modal fade" id="formEmployeeModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable modal-primary modal-xl  {{$maximize ?? ''}}" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModalLabel">{{$crud ? ucfirst($crud) : 'Create' }} | <span class="text-muted fw-normal">Employee</span></h5>
                <div>
                    <!--begin::maximize-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2 x-button" wire:click="maximize()">
                        <!--begin::Svg Icon | path: assets/media/icons/duotune/general/gen054.svg-->
                        <span class="svg-icon svg-icon-2x">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path opacity="0.5" d="M18 2H9C7.34315 2 6 3.34315 6 5H8C8 4.44772 8.44772 4 9 4H18C18.5523 4 19 4.44772 19 5V16C19 16.5523 18.5523 17 18 17V19C19.6569 19 21 17.6569 21 16V5C21 3.34315 19.6569 2 18 2Z" fill="currentColor"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M14.7857 7.125H6.21429C5.62255 7.125 5.14286 7.6007 5.14286 8.1875V18.8125C5.14286 19.3993 5.62255 19.875 6.21429 19.875H14.7857C15.3774 19.875 15.8571 19.3993 15.8571 18.8125V8.1875C15.8571 7.6007 15.3774 7.125 14.7857 7.125ZM6.21429 5C4.43908 5 3 6.42709 3 8.1875V18.8125C3 20.5729 4.43909 22 6.21429 22H14.7857C16.5609 22 18 20.5729 18 18.8125V8.1875C18 6.42709 16.5609 5 14.7857 5H6.21429Z" fill="currentColor"/>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::maximize-->
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2 x-button" wire:click="resetVariables" data-bs-dismiss="modal" aria-label="Close">
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
            </div>
            <div class="modal-body">
                <!-- ********************************************************************************** -->
                <!-- *** Start: Create Form -->
                <!-- ********************************************************************************** -->

                <form wire:submit.prevent="submit">

                    <!-- ********************************************************************************** -->
                    <!-- *** Start: Header -->
                    <!-- ********************************************************************************** -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card mb-5 shadow-sm">
                                <!--begin::card-body-->
                                <div class="card-body pt-16">
                                    <div class="row mb-5">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label required">First Name</label>
                                            <input wire:model="employee.first_name" type="text" class="form-control @if(!$disable) form-control-solid @endif @if($errors->has('employee.first_name')) is-invalid @endif" placeholder="First Name"  required @if($disable) disabled @endif>
                                            @error('employee.first_name') <span class="invalid-feedback">{{ $message }}</span>@enderror
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Middle Name</label>
                                            <input wire:model="employee.middle_name" type="text" class="form-control @if(!$disable) form-control-solid @endif @if($errors->has('employee.middle_name')) is-invalid @endif" placeholder="Middle Name"  required @if($disable) disabled @endif>
                                            @error('employee.middle_name') <span class="invalid-feedback">{{ $message }}</span>@enderror
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label required">Last Name</label>
                                            <input wire:model="employee.last_name" type="text" class="form-control @if(!$disable) form-control-solid @endif @if($errors->has('employee.last_name')) is-invalid @endif" placeholder="Last Name"  required @if($disable) disabled @endif>
                                            @error('employee.last_name') <span class="invalid-feedback">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label required">Position</label>
                                            <div wire:ignore >
                                                <select wire:model="employee.position_id" data-dropdown-parent="#formEmployeeModal" tabindex="-1" data-control="select2" data-placeholder="Select Position" class="form-select form-select-solid @if($errors->has('employee.position_id')) is-invalid @endif" id="position_id" required @if($disable) disabled @endif>
                                                    <option value="0"> Select Position </option>
                                                    @foreach($listOfPosition as $lod)
                                                        <option  value="{{$lod->id}}">{{$lod->pos_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('employee.position_id') <span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label required">Department</label>
                                            <div wire:ignore >
                                                <select wire:model="employee.department_id" data-dropdown-parent="#formEmployeeModal" tabindex="-1" data-control="select2" data-placeholder="Select Department/Office" class="form-select form-select-solid @if($errors->has('employee.department_id')) is-invalid @endif" id="department_id" required @if($disable) disabled @endif>
                                                    <option value="0"> Select Department/Office </option>
                                                    @foreach($listOfDepartment as $lod)
                                                        <option  value="{{$lod->id}}">{{$lod->dept_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('employee.department_id') <span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Employee No.</label>
                                            <input wire:model="employee.employee_no" type="text" class="form-control @if(!$disable) form-control-solid @endif @if($errors->has('employee.employee_no')) is-invalid @endif" placeholder="Employee No." @if($disable) disabled @endif>
                                            @error('employee.employee_no') <span class="invalid-feedback">{{ $message }}</span>@enderror
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label required">Birthday</label>
                                            <input wire:model="employee.birthday" type="date" class="form-control @if(!$disable) form-control-solid @endif @if($errors->has('employee.birthday')) is-invalid @endif" id="employee.birthday" @if($disable) disabled @endif>
                                            @error('employee.birthday') <span class="invalid-feedback">{{ $message }}</span>@enderror
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label required">Sex</label>
                                            <div class="d-flex">
                                                <div class="form-check form-check-custom form-check-solid me-8">
                                                    <input class="form-check-input h-30px w-30px" type="radio" wire:model="employee.sex" name="sex" value="1" id="purpose_disposal" @if($disable) disabled @endif/>
                                                    <label class="form-check-label" for="purpose_disposal">
                                                        Male
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-custom form-check-solid me-8">
                                                    <input class="form-check-input h-30px w-30px" type="radio" wire:model="employee.sex" name="sex" value="2" id="purpose_repair" @if($disable) disabled @endif/>
                                                    <label class="form-check-label" for="purpose_repair">
                                                        Female
                                                    </label>
                                                </div>
                                            </div>
                                            @error('employee.sex') <span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Email</label>
                                            <input wire:model="employee.email" type="text" class="form-control @if(!$disable) form-control-solid @endif @if($errors->has('employee.email')) is-invalid @endif" placeholder="Email Address" @if($disable) disabled @endif>
                                            @error('employee.email') <span class="invalid-feedback">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Mobile No.</label>
                                            <input wire:model="employee.mobile_nos" type="text" class="form-control @if(!$disable) form-control-solid @endif @if($errors->has('employee.mobile_nos')) is-invalid @endif" placeholder="Mobile No."  @if($disable) disabled @endif>
                                            @error('employee.mobile_nos') <span class="invalid-feedback">{{ $message }}</span>@enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Telephone No.</label>
                                            <input wire:model="employee.tel_nos" type="text" class="form-control @if(!$disable) form-control-solid @endif @if($errors->has('employee.tel_nos')) is-invalid @endif" placeholder="Telephone No."  @if($disable) disabled @endif>
                                            @error('employee.tel_nos') <span class="invalid-feedback">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col-md-3 mb-3">
                                            <label>Avatar</label>
                                            <div class="form-group">
                                                <input wire:model="avatar" id="avatar" placeholder="Please attach file/s." class="form-control @if($errors->has("avatar")) is-invalid @endif" type="file" accept="image/png, image/gif, image/jpeg, image/jpg">
                                                {{--<input type="hidden" name="avatar" value="{{$employee->id}}" />--}}
                                            </div>
                                            @error('avatar') <span class="error invalid-feedback">{{ $message }}</span> @enderror
                                            <div wire:loading wire:target="avatar">Uploading...</div>
                                            @if(!empty($avatar))
                                                Photo Preview:
                                                @if(!empty($avatar->temporaryUrl()))
                                                    <img src="{{ $avatar->temporaryUrl() }}" style="object-fit: scale-down; border-radius: 4px; width: 100%; height: 80px;" />
                                                @endif
                                            @elseif(!empty($employee->avatar))
                                                Photo Preview:
                                                <div class="position-relative">
                                                    @if(!$disable)
                                                        <button wire:click.prevent="DeleteAvatar({{$employee->id}});" avatar="{{$employee->id}}"  title="Delete this image?" class="opacity-75-hover border border-transparent position-absolute cursor-pointer top-0 start-100 z-index-3 translate-middle badge badge-circle bg-danger" style="top: 10px !important;">
                                                            <i class="las la-times text-white"></i>
                                                        </button>
                                                    @endif
                                                    {{--xls, .xlsx, .doc, .docx, .pdf--}}
                                                    <a class="z-index-0" href="{{ asset('storage/'.$employee->avatar) }}" target="_blank">
                                                        @if (file_exists( public_path('storage/'.$employee->avatar)) )
                                                            <img src="{{ asset('storage/'.$employee->avatar) }}" class="mt-3" style="border: 1px solid #E4E6EF; object-fit: scale-down; border-radius: 4px; width: 100%; height: 100px; padding: 6px;" >
                                                        @else
                                                            <img src="{{ asset('file_type/icon-none.png') }}" class="mt-3" style="border: 1px solid #E4E6EF; object-fit: scale-down; border-radius: 4px; width: 100%; height: 100px; padding: 6px;" >
                                                        @endif
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label>Signature</label>
                                            <div class="form-group">
                                                <input wire:model="signature" id="signature" placeholder="Please attach file/s." class="form-control @if($errors->has("signature")) is-invalid @endif" type="file" accept="image/png, image/gif, image/jpeg, image/jpg">
                                            </div>
                                            @error('signature') <span class="error invalid-feedback">{{ $message }}</span> @enderror
                                            <div wire:loading wire:target="signature">Uploading...</div>
                                            @if(!empty($signature))
                                                Photo Preview:
                                                @if(!empty($signature->temporaryUrl()))
                                                    <img src="{{ $signature->temporaryUrl() }}" style="object-fit: scale-down; border-radius: 4px; width: 100%; height: 80px;" />
                                                @endif
                                            @elseif(!empty($employee->signature))
                                                Photo Preview:
                                                <div class="position-relative">
                                                    @if(!$disable)
                                                        <button wire:click.prevent="DeleteSignature({{$employee->id}});" title="Delete this image?" class="opacity-75-hover border border-transparent position-absolute cursor-pointer top-0 start-100 z-index-3 translate-middle badge badge-circle bg-danger" style="top: 10px !important;">
                                                            <i class="las la-times text-white"></i>
                                                        </button>
                                                    @endif
                                                    {{--xls, .xlsx, .doc, .docx, .pdf--}}
                                                    <a class="z-index-0" href="{{ asset('storage/'.$employee->signature) }}" target="_blank">
                                                        @if (file_exists( public_path('storage/'.$employee->signature)) )
                                                            <img src="{{ asset('storage/'.$employee->signature) }}" class="mt-3" style="border: 1px solid #E4E6EF; object-fit: scale-down; border-radius: 4px; width: 100%; height: 100px; padding: 6px;" >
                                                        @else
                                                            <img src="{{ asset('file_type/icon-none.png') }}" class="mt-3" style="border: 1px solid #E4E6EF; object-fit: scale-down; border-radius: 4px; width: 100%; height: 100px; padding: 6px;" >
                                                        @endif
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <!--end::card-body-->
                            </div>
                        </div>
                    </div>

                    <!-- ********************************************************************************** -->
                    <!-- *** End: Header -->
                    <!-- ********************************************************************************** -->

                </form>

                <!-- ********************************************************************************** -->
                <!-- *** End: Create Form -->
                <!-- ********************************************************************************** -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-btn" wire:click="resetVariables" data-bs-dismiss="modal">Close</button>
                @if($crud == 'create')
                    <button class="btn btn-primary close-modal px-5" wire:click.prevent="store" wire:loading.attr="disabled"><div wire:loading wire:target="store"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></div> Save</button>
                @elseif($crud == 'show')
                    <style>
                        {{-- Disable Trix Editor --}}
                        trix-editor,
                        trix-toolbar {
                            pointer-events: none;
                        }
                    </style>
                    <button class="btn btn-primary close-modal px-5" wire:click.prevent="edit({{$employee->id}})" wire:loading.attr="disabled"><div wire:loading wire:target="edit"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></div> Edit</button>
                @elseif($crud == 'edit')
                    <button class="btn btn-primary close-modal px-5" wire:click.prevent="update" wire:loading.attr="disabled"><div wire:loading wire:target="update"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></div> Update</button>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function () {

            window.livewire.on('EmployeeResetAndLoadSelect2', event => {
                $('#department_id').select2("enable");
                $('#position_id').select2("enable");

                $('#department_id').select2().val(null).trigger('change');
                $('#department_id').on('change', function (e) {
                    @this.set('employee.department_id', e.target.value);
                });

                $('#position_id').select2().val(null).trigger('change');
                $('#position_id').on('change', function (e) {
                    @this.set('employee.position_id', e.target.value);
                });
            });



            window.livewire.on('EmployeeLoadDefaultValue', data => {

                $('.modal-body').animate({ scrollTop: 300 }, 'slow');

                $('#department_id').select2("enable");
                $('#position_id').select2("enable");

                $('#department_id').select2().val(data.department_id).trigger('change');
                $('#department_id').on('change', function (e) {
                    @this.set('employee.department_id', e.target.value);
                });

                $('#position_id').select2().val(data.position_id).trigger('change');
                $('#position_id').on('change', function (e) {
                    @this.set('employee.position_id', e.target.value);
                });

            });

            window.livewire.on('EmployeeLoadDefaultValueAndDisable', data => {
                $('#department_id').select2("enable",false);
                $('#position_id').select2("enable",false);

                $('#department_id').select2().val(data.department_id).trigger('change');
                $('#position_id').select2().val(data.position_id).trigger('change');
            });

            window.addEventListener('scrollToBottom', event => {
                // $('.modal-body').animate({ scrollTop: 500 }, 'slow');
                // // $('.modal-body').animate({ scrollTop: $('#formModal .modal-body').height() }, 'slow');
                // console.log($('#formModal .modal-body').height());
            });

        });
    </script>


@endpush
