<div>
    <!-- ********************************************************************************** -->
    <!-- *** Start: Modal Attach Item -->
    <!-- ********************************************************************************** -->
    <div wire:ignore.self class="modal fade bg-opacity-50 bg-dark" id="kt_modal_setstatus" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-primary">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModalLabel">Set Status</h5>
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

                <div class="modal-body">
                    <!-- ********************************************************************************** -->
                    <!-- *** Start: Attach Item -->
                    <!-- ********************************************************************************** -->
                    <form>
                        <div class="row mb-5">
                            <div class="col-md-12 mb-3">
                                <label class="form-label required">Set Status</label>
                                <div wire:ignore >
                                    <select wire:model="trip.status" data-dropdown-parent="#kt_modal_setstatus" tabindex="-1" data-control="select2" data-placeholder="Select Status" class="form-select form-select-solid @if($errors->has('trip.status')) is-invalid @endif" id="trip_status" >
                                        <option value="0"> Select Status </option>
                                        @foreach($DocStatus as $status)
                                            <option  value="{{$status->id}}">{{$status->status}}</option>
                                        @endforeach
                                    </select>
                                    @error('trip.status') <span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Date and Time:</label>
                                <input wire:model="trip.status_date" type="datetime-local" class="form-control @if(!$disable) form-control-solid @endif @if($errors->has('trip.status_date')) is-invalid @endif" id="trip.status_date" required @if($disable) disabled @endif>
                                @error('trip.status_date') <span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">By</label>
                                @if(!$disable)
                                    <livewire:components.setby-search-employee :placeholder="'Search employee'" :show="$disable" :wire:key="'setby-'.$setbyId"/>
                                @else
                                    {{--<input type="text" class="form-control bg-light-primary" disabled>--}}
                                @endif
                                @if(!empty($trip->setby))
                                    <div class="position-relative border p-3 mt-5">
                                        @if(!$disable)
                                            <button wire:click.prevent="clear_set_by" title="Remove employee" class="opacity-75-hover border border-transparent position-absolute cursor-pointer top-0 start-100 z-index-3 translate-middle badge badge-circle bg-danger" style="top: 0px !important;">
                                                <i class="las la-times text-white"></i>
                                            </button>
                                        @endif
                                        <div class="text-center pt-3">
                                            <p class="border-bottom text-uppercase">
                                                <strong>{{$trip->setby_name ?? ''}}</strong><br/>
                                                {{$trip->setby_designation ?? ''}}
                                            </p>
                                            <p>
                                                {{$trip->setby_office ?? ''}}
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Remarks</label>
                                {{--<input wire:model="wmrdetail.remarks" type="text" class="form-control @if(!$disable) form-control-solid @endif @if($errors->has('wmrdetail.remarks')) is-invalid @endif" @if($disable) disabled @endif>--}}
                                <textarea wire:model="trip.setby_remarks" rows="2" class="form-control @if(!$disable) form-control-solid @endif @if($errors->has('trip.remarks')) is-invalid @endif" @if($disable) disabled @endif></textarea>
                                @error('trip.remarks') <span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </form>
                    <!-- ********************************************************************************** -->
                    <!-- *** End: Attach Item -->
                    <!-- ********************************************************************************** -->
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    @if($crud == 'create')
                        <button class="btn btn-primary px-5" wire:click.prevent="store" wire:loading.attr="disabled"><div wire:loading wire:target="store"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></div> Save </button>
                    @elseif($crud == 'edit')
                        <button class="btn btn-primary px-5" wire:click.prevent="update({{$trip->id}})" wire:loading.attr="disabled"><div wire:loading wire:target="update"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></div> Update </button>
                    @endif
                    {{--<button class="btn btn-primary px-5" wire:click.prevent="SaveNewTask" wire:loading.attr="disabled"><div wire:loading wire:target="SaveNewTask"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></div> <i class="las la-plus-circle fs-2"></i> Save </button>--}}
                </div>
            </div>
        </div>
    </div>
    <!-- ********************************************************************************** -->
    <!-- *** End: Modal Attach Item -->
    <!-- ********************************************************************************** -->
</div>


@push('scripts')
    <script>
        $(document).ready(function () {
            window.livewire.on('setby_resetItem', event => {
                $('#trip_status').select2("enable");
                $('#trip_status').select2({minimumResultsForSearch: 10 }).val(null).trigger('change');
                $('#trip_status').on('change', function (e) {
                    @this.set('trip.status', e.target.value, true);
                });
            });

            window.livewire.on('setby_loadDefaultValue', data => {
                $('#trip_status').select2("enable");
                $('#trip_status').select2().val(data.status).trigger('change');
                $('#trip_status').on('change', function (e) {
                @this.set('trip.status', e.target.value, true);
                });

                $('#setby').select2("enable");
                $('#setby').select2().val(data.setby).trigger('change');
                $('#setby').on('change', function (e) {
                @this.set('trip.setby', e.target.value);
                });
            });

            window.livewire.on('setby_loadValueAndDisable', data => {
                $('#trip_status').select2("enable",false);
                $('#trip_status').select2().val(data.status).trigger('change');
            });

            window.addEventListener('openModal_setstatus', event => {
                $("#kt_modal_setstatus").modal('show');
            });
            window.addEventListener('closeModal_setstatus', event => {
                $("#kt_modal_setstatus").modal('hide');
            });
        });
    </script>
@endpush


