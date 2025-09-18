<!-- Modal For Create-->
<div wire:ignore.self class="modal fade" id="formModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable modal-primary modal-xl  {{$maximize ?? ''}}" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModalLabel">{{$crud ? ucfirst($crud) : 'Create' }} | <span class="text-muted fw-normal">Trip Ticket</span></h5>
                <div>
                    @if($crud == 'edit' || $crud == 'show')
                        @role('admin|divisionhead|departmenthead|approver')
                        <button type="button" class="btn btn-sm {{!empty($trip->status_date) ? 'btn-light-success ' : 'btn-light-primary ' }} x-button py-1 px-4" wire:click="setstatus({{$trip->id}})">
                            <!--begin::Svg Icon | path: assets/media/icons/duotune/arrows/arr084.svg-->
                            <span class="svg-icon svg-icon-2x">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path opacity="0.5" d="M12.8956 13.4982L10.7949 11.2651C10.2697 10.7068 9.38251 10.7068 8.85731 11.2651C8.37559 11.7772 8.37559 12.5757 8.85731 13.0878L12.7499 17.2257C13.1448 17.6455 13.8118 17.6455 14.2066 17.2257L21.1427 9.85252C21.6244 9.34044 21.6244 8.54191 21.1427 8.02984C20.6175 7.47154 19.7303 7.47154 19.2051 8.02984L14.061 13.4982C13.7451 13.834 13.2115 13.834 12.8956 13.4982Z" fill="currentColor"/>
                                    <path d="M7.89557 13.4982L5.79487 11.2651C5.26967 10.7068 4.38251 10.7068 3.85731 11.2651C3.37559 11.7772 3.37559 12.5757 3.85731 13.0878L7.74989 17.2257C8.14476 17.6455 8.81176 17.6455 9.20663 17.2257L16.1427 9.85252C16.6244 9.34044 16.6244 8.54191 16.1427 8.02984C15.6175 7.47154 14.7303 7.47154 14.2051 8.02984L9.06096 13.4982C8.74506 13.834 8.21146 13.834 7.89557 13.4982Z" fill="currentColor"/>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            {{!empty($trip->status_date) ? 'Edit ' : 'Set ' }}
                            Status
                        </button>
                        @endrole
                    @endif
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
                                        <div class="col-md-2 mb-3">
                                            @if(!empty($VehiclePlateNo))
                                                <label class="form-label required">Vehicle Plate No.</label>
                                                <select wire:model="trip.vehicle_plate_no" class="form-select" @if($disable) disabled @endif >
                                                    <option> Select Plate No. </option>
                                                    @foreach($VehiclePlateNo as $PlateNo)
                                                        <option  value="{{$PlateNo->vehicle_plate_no}}">{{$PlateNo->vehicle_plate_no}}</option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </div>
                                        <div class="col-md-5 mb-3">
                                            <label class="form-label required">Person in Charge / Driver</label>
                                            @if(!$disable)
                                                <livewire:components.search-employee :placeholder="'Search employee'" :show="$disable" :wire:key="'se-'.$seId"/>
                                            @else
                                                <input type="text" class="form-control bg-light-primary" disabled>
                                            @endif
                                            @if(!empty($trip->person_in_charge_id))
                                                <div class="position-relative border p-3 mt-5">
                                                    @if(!$disable)
                                                        <button wire:click.prevent="clear_employee" title="Remove employee" class="opacity-75-hover border border-transparent position-absolute cursor-pointer top-0 start-100 z-index-3 translate-middle badge badge-circle bg-danger" style="top: 0px !important;">
                                                            <i class="las la-times text-white"></i>
                                                        </button>
                                                    @endif
                                                    <div class="text-center pt-3">
                                                        <p class="border-bottom text-uppercase">
                                                            <strong>{{$trip->person_in_charge_name ?? ''}}</strong><br/>
                                                            {{$trip->person_in_charge_designation ?? ''}}
                                                        </p>
                                                        <p>
                                                            {{$trip->person_in_charge_office ?? ''}}
                                                        </p>
                                                    </div>
                                                </div>
                                            @endif
                                            @error('trip.person_in_charge_id') <span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label required">Transaction Date and Time</label>
                                            <input wire:model="trip.transaction_datetime" type="datetime-local" class="form-control @if(!$disable) form-control-solid @endif @if($errors->has('trip.transaction_datetime')) is-invalid @endif" id="trip.transaction_datetime" required @if($disable) disabled @endif>
                                            @error('trip.transaction_datetime') <span class="invalid-feedback">{{ $message }}</span>@enderror
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            @if(!empty($DocStatus))
                                                <label class="form-label">Status</label>
                                                <select wire:model="trip.status" class="form-select" disabled>
                                                    <option> Select Status </option>
                                                    @foreach($DocStatus as $status)
                                                        <option  value="{{$status->id}}">{{$status->status}}</option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row mb-5">
                                        <div class="col-md-5 mb-3">
                                            <label class="form-label required">Origin</label>
                                            <input wire:model="trip.origin" type="text" class="form-control @if(!$disable) form-control-solid @endif @if($errors->has('trip.origin')) is-invalid @endif" placeholder="Origin"  required @if($disable) disabled @endif>
                                            @error('trip.origin') <span class="invalid-feedback">{{ $message }}</span>@enderror
                                        </div>

                                        <div class="form-check form-check-custom form-check-solid form-check-lg mt-10 col-md-2 mb-3">
                                            <input wire:model="trip.round_trip" class="form-check-input @if($errors->has('trip.round_trip')) is-invalid @endif" type="checkbox" value="" id="trip.round_trip"/>
                                            <label class="form-check-label" for="proprietary">
                                                Round-trip
                                            </label>
                                            @error('trip.round_trip') <span class="invalid-feedback">{{ $message }}</span>@enderror
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label class="form-label required">Departure</label>
                                            <input wire:model="trip.departure" type="datetime-local" class="form-control @if(!$disable) form-control-solid @endif @if($errors->has('trip.departure')) is-invalid @endif" id="trip.departure" required @if($disable) disabled @endif>
                                            @error('trip.departure') <span class="invalid-feedback">{{ $message }}</span>@enderror
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label class="form-label required">Starting ODO</label>
                                            <input wire:model="trip.starting_ODO" type="number" step='1' min="0" class="form-control @if(!$disable) form-control-solid @endif  @if($errors->has('trip.starting_ODO')) is-invalid @endif" placeholder="Starting ODO" required @if($disable) disabled @endif>
                                            @error('trip.starting_ODO') <span class="invalid-feedback">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col-md-7 mb-3">
                                            <label class="form-label required">Destination</label>
                                            <input wire:model="trip.destination" type="text" class="form-control @if(!$disable) form-control-solid @endif @if($errors->has('trip.destination')) is-invalid @endif" placeholder="Destination"  required @if($disable) disabled @endif>
                                            @error('trip.destination') <span class="invalid-feedback">{{ $message }}</span>@enderror
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label required">Arrival</label>
                                            <input wire:model="trip.arrival" type="datetime-local" class="form-control @if(!$disable) form-control-solid @endif @if($errors->has('trip.arrival')) is-invalid @endif" id="trip.arrival" required @if($disable) disabled @endif>
                                            @error('trip.arrival') <span class="invalid-feedback">{{ $message }}</span>@enderror
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label class="form-label required">Ending ODO</label>
                                            <input wire:model="trip.ending_ODO" type="number" step='1' min="0" class="form-control @if(!$disable) form-control-solid @endif  @if($errors->has('trip.ending_ODO')) is-invalid @endif" placeholder="Ending ODO" required @if($disable) disabled @endif>
                                            @error('trip.ending_ODO') <span class="invalid-feedback">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col-md-10 mb-3">
                                            <label class="form-label">Visited Places</label>
                                            <input wire:model="trip.visited_places" type="text" class="form-control @if(!$disable) form-control-solid @endif @if($errors->has('trip.visited_places')) is-invalid @endif" placeholder="Visited Places" required @if($disable) disabled @endif>
                                            @error('trip.visited_places') <span class="invalid-feedback">{{ $message }}</span>@enderror
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label class="form-label">Total Mileage</label>
                                            <input wire:model="trip.total_mileage" type="number" step='1' min="0" class="form-control @if(!$disable) form-control-solid @endif  @if($errors->has('trip.total_mileage')) is-invalid @endif" placeholder="Total Mileage" required @if($disable) disabled @endif>
                                            @error('trip.total_mileage') <span class="invalid-feedback">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col-md-6 mb-3">
                                            <div class="trip_purpose_trip_details" wire:ignore>
                                                <label class="form-label">Purpose Trip Details</label>
                                                <textarea wire:model="trip.purpose_trip_details"
                                                          class="min-h-fit h-40 "
                                                          name="purpose_trip_details"
                                                          id="trip_purpose_trip_details">
                                                </textarea>
                                            </div>
                                            @error('trip.purpose_trip_details') <span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="trip_authorized_passengers" wire:ignore>
                                                <label class="form-label">Authorized Passengers</label>
                                                <textarea wire:model="trip.authorized_passengers"
                                                          class="min-h-fit h-40 "
                                                          name="purpose_trip_details"
                                                          id="trip_authorized_passengers">
                                                </textarea>
                                            </div>
                                            @error('trip.authorized_passengers') <span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                                        </div>
                                    </div>

                                    <div class="row mb-5">
                                        <h6 class="mt-5 overflow-auto">Attachment/s
                                            @if(!$disable)
                                                <a class="float-end btn btn-link btn-color-primary px-5" wire:click.prevent="add({{$i}})"><i class="las la-plus-circle fs-2"></i> Add attachment</a>
                                            @endif
                                        </h6>
                                        @if(!empty($attachmentList))
                                            <div class="row">
                                                @endif
                                                @foreach($attachmentList ?? [] as $attachment)
                                                    <div class="col-2">
                                                        <div class="position-relative">
                                                            @if(!$disable)
                                                                <button wire:click.prevent="DeleteAttachment({{$attachment->id}});" title="Delete - {{ $attachment->title ?? '' }}" class="opacity-75-hover border border-transparent position-absolute cursor-pointer top-0 start-100 z-index-3 translate-middle badge badge-circle bg-danger" style="top: 10px !important;">
                                                                    <i class="las la-times text-white"></i>
                                                                </button>
                                                            @endif
                                                            {{--xls, .xlsx, .doc, .docx, .pdf--}}
                                                            <a class="z-index-0" href="{{ asset('storage/'.$attachment->filename) }}" target="_blank">
                                                                @if(($attachment->type == 'png') || ($attachment->type == 'gif') || ($attachment->type == 'jpeg') || ($attachment->type == 'jpg'))
                                                                    <img src="{{ asset('storage/'.$attachment->filename) }}" class="mt-3" style="border: 1px solid #E4E6EF; object-fit: scale-down; border-radius: 4px; width: 100%; height: 100px; padding: 6px;" >
                                                                @elseif(($attachment->type == 'doc') || ($attachment->type == 'docx'))
                                                                    <img src="{{ asset('file_type/icon-doc.png') }}" class="mt-3" style="border: 1px solid #E4E6EF; object-fit: scale-down; border-radius: 4px; width: 100%; height: 100px; padding: 6px;" >
                                                                @elseif($attachment->type == 'pdf' || ($attachment->type == 'PDF'))
                                                                    <img src="{{ asset('file_type/icon-pdf.png') }}" class="mt-3" style="border: 1px solid #E4E6EF; object-fit: scale-down; border-radius: 4px; width: 100%; height: 100px; padding: 6px;" >
                                                                @elseif($attachment->type == 'xls' || $attachment->type == 'xlsx')
                                                                    <img src="{{ asset('file_type/icon-xls.png') }}" class="mt-3" style="border: 1px solid #E4E6EF; object-fit: scale-down; border-radius: 4px; width: 100%; height: 100px; padding: 6px;" >
                                                                @elseif($attachment->type == 'shp')
                                                                    <img src="{{ asset('file_type/icon-shp.png') }}" class="mt-3" style="border: 1px solid #E4E6EF; object-fit: scale-down; border-radius: 4px; width: 100%; height: 100px; padding: 6px;" >
                                                                @else
                                                                    <img src="{{ asset('file_type/icon-none.png') }}" class="mt-3" style="border: 1px solid #E4E6EF; object-fit: scale-down; border-radius: 4px; width: 100%; height: 100px; padding: 6px;" >
                                                                @endif
                                                            </a>
                                                        </div>
                                                        <p class="text-center py-3">{{ $attachment->title ?? '' }}</p>
                                                    </div>
                                                @endforeach
                                                @if(!empty($attachmentList))
                                            </div>
                                        @endif
                                        @foreach($input as $key => $value)
                                            <div class=" add-input mt-3">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <input wire:model="attachment.{{ $value }}" placeholder="Please attach file/s." class="form-control @if($errors->has("attachment.".$value)) is-invalid @endif" type="file" accept="image/*, .xls, .xlsx, .doc, .docx, .pdf, .shp" required>
                                                            @error('attachment.'.$value) <span class="text-danger error">{{ $message }}</span>@enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control form-control-solid @if($errors->has("filename.".$value)) is-invalid @endif" wire:model="filename.{{ $value }}" placeholder="Enter Filename" required>
                                                            @error('filename.'.$value) <span class="text-danger error">{{ $message }}</span>@enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button class="btn btn-danger" wire:click.prevent="remove({{$key}})">remove</button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
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
                    <button class="btn btn-primary close-modal px-5" wire:click.prevent="edit({{$trip->id}})" wire:loading.attr="disabled" @if($disableeditdetails) disabled @endif><div wire:loading wire:target="edit"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></div> Edit</button>
                @elseif($crud == 'edit')
                    <button class="btn btn-primary close-modal px-5" wire:click.prevent="update" wire:loading.attr="disabled"><div wire:loading wire:target="update"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></div> Update</button>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <style>
        .ck.ck-editor__main>.ck-editor__editable:not(.ck-focused) {
            background-color: #F5F8FA !important;
            border: 1px solid #E4E6EF !important;
            color: #5E6278 !important;
        }
        .ck.ck-editor__main>.ck-editor__editable{
            background-color: #eef3f7 !important;
            border: 1px solid #E4E6EF !important;
            color: #5E6278 !important;
        }
        .ck.ck-toolbar {
            background-color: #F5F8FA !important;
            border-bottom: none !important;
            border-left: 1px solid #E4E6EF !important;
            border-right: 1px solid #E4E6EF !important;
            border-top: 1px solid #E4E6EF !important;
        }
        .ck-editor__editable { min-height: 100px; }
    </style>
    <script src="https://cdn.ckeditor.com/ckeditor5/27.1.0/classic/ckeditor.js"></script>
    <script>
        $(document).ready(function () {
            let ckEditorPurpose, ckEditorPassengers, ckEditorPlaces;
            ClassicEditor
                // .create(document.querySelector('#risheader_remarks'))
                .create(document.querySelector('#trip_purpose_trip_details'),{
                    toolbar: {
                        items: [
                            'heading', '|',
                            'fontfamily', 'fontsize', '|',
                            'alignment', '|',
                            'fontColor', 'fontBackgroundColor', '|',
                            'bold', 'italic', 'strikethrough', 'underline', 'subscript', 'superscript', '|',
                            'link', '|',
                            'outdent', 'indent', '|',
                            'bulletedList', 'numberedList', 'todoList', '|',
                            'undo', 'redo'
                        ],
                        shouldNotGroupWhenFull: true
                    }
                })
                .then(editor => {
                    editor.model.document.on('change:data', () => {
                        @this.set('trip.purpose_trip_details', editor.getData());
                    });
                    ckEditorPurpose = editor;
                })
                .catch(error => {
                    console.error(error);
                });

            ClassicEditor
                .create(document.querySelector('#trip_authorized_passengers'),{
                    toolbar: {
                        items: [
                            'heading', '|',
                            'fontfamily', 'fontsize', '|',
                            'alignment', '|',
                            'fontColor', 'fontBackgroundColor', '|',
                            'bold', 'italic', 'strikethrough', 'underline', 'subscript', 'superscript', '|',
                            'link', '|',
                            'outdent', 'indent', '|',
                            'bulletedList', 'numberedList', 'todoList', '|',
                            'undo', 'redo'
                        ],
                        shouldNotGroupWhenFull: true
                    }
                })
                .then(editor => {
                    editor.model.document.on('change:data', () => {
                        @this.set('trip.authorized_passengers', editor.getData());
                    });
                    ckEditorPassengers = editor;
                })
                .catch(error => {
                        console.error(error);
                });

            window.livewire.on('resetAndLoadSelect2', event => {

                ckEditorPurpose.isReadOnly = false;
                ckEditorPurpose.setData('');

                ckEditorPassengers.isReadOnly = false;
                ckEditorPassengers.setData('');

            });

            window.livewire.on('loadDefaultValue', data => {

                $('.modal-body').animate({ scrollTop: 300 }, 'slow');
             // $('.modal-body').animate({ scrollTop: $('#formModal .modal-body').height() }, 'slow');

                ckEditorPurpose.isReadOnly = false;
                ckEditorPurpose.setData(data.purpose_trip_details);

                ckEditorPassengers.isReadOnly = false;
                ckEditorPassengers.setData(data.authorized_passengers);

            });

            window.livewire.on('loadDefaultValueAndDisable', data => {

                ckEditorPurpose.isReadOnly = true;
                ckEditorPurpose.setData(data.purpose_trip_details);

                ckEditorPassengers.isReadOnly = true;
                ckEditorPassengers.setData(data.authorized_passengers);

            });

            window.addEventListener('scrollToBottom', event => {
                // $('.modal-body').animate({ scrollTop: 500 }, 'slow');
                // // $('.modal-body').animate({ scrollTop: $('#formModal .modal-body').height() }, 'slow');
                // console.log($('#formModal .modal-body').height());
            });

        });
    </script>


@endpush
