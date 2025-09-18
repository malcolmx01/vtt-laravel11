<div>
    <!-- ********************************************************************************** -->
    <!-- *** Start: Modal Attach Item -->
    <!-- ********************************************************************************** -->
    <div wire:ignore.self class="modal fade bg-opacity-50 bg-dark" id="kt_modal_attach_item" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-primary modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModalLabel">{{$crud ? ucfirst($crud) : 'Attach' }} | <span class="text-muted fw-normal">RIS Details</span></h5>
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
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">RIS No.</label>
                                <input wire:model="risdetail.ris_no" type="text" class="form-control @if($errors->has('risdetail.ris_no')) is-invalid @endif" placeholder="RIS No." disabled>
                                @error('risdetail.ris_no') <span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-md-9 mb-3">
                                <label class="form-label">Item Name</label>
                                <input wire:model="risdetail.item_description" type="text" class="form-control @if($errors->has('risdetail.item_description')) is-invalid @endif" placeholder="Item Description" disabled>
                                @error('risdetail.item_description') <span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        {{--<div class="row">--}}
                            {{--<div class="col-md-12 mb-3">--}}
                                {{--<label class="form-label">Detailed Description</label>--}}
                                {{--<livewire:components.trix-editor :value="$risdetail->details ?? ''" :wire:key="$crud.'-'.$risdetail->id ?? $trixRndId" id="add_content" />--}}
                                {{--@if($crud == 'show')--}}
                                {{--<style>--}}
                                    {{-- Disable Trix Editor --}}
                                    {{--trix-editor,--}}
                                    {{--trix-toolbar {--}}
                                        {{--pointer-events: none;--}}
                                    {{--}--}}
                                {{--</style>--}}
                                {{--@endif--}}
                                {{--@error('$risdetail.details') <span class="invalid-feedback d-block">{{ $message }}</span>@enderror--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        <div class="row mb-3">
                            <div class="col-md-12 mb-3 risdetail_details" wire:ignore>
                                <label class="form-label">Detailed Description</label>
                                <textarea wire:model="risdetail.details"
                                          name="details"
                                          id="risdetail_details">
                                            </textarea>
                            </div>
                            @error('risdetail.details') <span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                        </div>

                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label required">Amount</label>
                                <input wire:model="risdetail.unit_cost" type="number" step='1' min="0" class="form-control @if(!$disable) form-control-solid @endif  @if($errors->has('risdetail.unit_cost')) is-invalid @endif" placeholder="Unit Cost" required @if($disable) disabled @endif>
                                @error('risdetail.unit_cost') <span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label required">Quantity</label>
                                <input wire:model="risdetail.quantity" type="number" step='1' min="0" class="form-control @if(!$disable) form-control-solid @endif  @if($errors->has('risdetail.quantity')) is-invalid @endif" placeholder="Item Quantity" required @if($disable) disabled @endif>
                                @error('risdetail.quantity') <span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Unit</label>
                                <input wire:model="risdetail.unit_description" type="text" class="form-control @if(!$disable) form-control-solid @endif  @if($errors->has('risdetail.unit_description')) is-invalid @endif" placeholder="Item Quantity" required @if($disable) disabled @endif>
                                @error('risdetail.unit_description') <span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Total Value</label>
                                <input wire:model="risdetail.total_value" type="number" step='1' min="0"  class="form-control @if($errors->has('risdetail.total_value')) is-invalid @endif" placeholder="Total Value" disabled>
                                @error('risdetail.total_value') <span class="invalid-feedback">{{ $message }}</span>@enderror
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
                        <button class="btn btn-primary px-5" wire:click.prevent="update({{$risdetail->id}})" wire:loading.attr="disabled"><div wire:loading wire:target="update"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></div> Update </button>
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
            let ckEditorItem;
            ClassicEditor
                // .create(document.querySelector('#risdetail_details'))
                .create(document.querySelector('#risdetail_details'),{
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
                            @this.set('risdetail.details', editor.getData());
                    });
                    ckEditorItem = editor;
                })
                .catch(error => {
                    console.error(error);
                });

            window.livewire.on('attach_resetItem', event => {
                ckEditorItem.isReadOnly = false;
                ckEditorItem.setData('');
            });

            window.livewire.on('attach_loadDefaultValue', data => {
                ckEditorItem.isReadOnly = false;
                ckEditorItem.setData(data.details);
            });

            window.livewire.on('attach_loadValueAndDisable', data => {
                ckEditorItem.isReadOnly = true;
                ckEditorItem.setData(data.details);
            });

            window.addEventListener('openModal_attach_item', event => {
                $("#kt_modal_attach_item").modal('show');
            });
            window.addEventListener('closeModal_attach_item', event => {
                $("#kt_modal_attach_item").modal('hide');
            });
        });
    </script>
@endpush


