@section('toolbar-menu')
    <!--begin::Wrapper-->
    <div data-bs-toggle="tooltip" data-bs-placement="left" data-bs-trigger="hover" title="Create New Record">
        <a class="btn btn-sm btn-primary fw-bolder" class="createModal">
            Create
        </a>
    </div>
    <!--end::Wrapper-->
@endsection

<div>
    <!-- ********************************************************************************** -->
    <!-- *** Start: Message Box -->
    <!-- ********************************************************************************** -->

    @include('livewire.components.notification')

    <!-- ********************************************************************************** -->
    <!-- *** End: Message Box -->
    <!-- ********************************************************************************** -->

    @include('livewire.vtt.trips.archive')
    @include('livewire.vtt.trips.form')

    <div>
        <livewire:vtt.trips-set-status :wire:key="'setstat-'.$setstatusid"/>
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
    {{--<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>--}}
    <script type="text/javascript">

        $(document).ready(function () {
            $( ".createModal" ).click(function() {
                window.livewire.emit('CreateNewRecord');
            });
        });

        window.addEventListener('openFormModal', event => {
            $("#formModal").modal('show');
        });
        window.addEventListener('closeFormModal', event => {
            $("#formModal").modal('hide');
        });

        window.livewire.on('goToTopPage', () => {
            scrollTo({top: 0, behavior: 'smooth'});
        });

        window.livewire.on('showDeleteConfirmation', data => {
            swal.fire({
            html: "Are you sure to delete " + data.detail.are_no + " ?",
            icon: 'warning',
            buttonsStyling: false,
            confirmButtonText: "Yes, Delete!",
            showCancelButton: true,
            cancelButtonText: "No, Cancel",
            customClass: {
                confirmButton: "btn btn-danger",
                cancelButton: 'btn btn-secondary'
            }
            }).then(function(result) {
                if (result.value) {
                    livewire.emit('delete',data.detail.id);
                }
            });
        });

        window.livewire.on('showDeleteDetailsConfirmation', data => {
            swal.fire({
            html: "Are you sure to delete (" + data.detail.item_description + ") with id no.: "+ data.detail.id +" ?",
            icon: 'warning',
            buttonsStyling: false,
            confirmButtonText: "Yes, Delete!",
            showCancelButton: true,
            cancelButtonText: "No, Cancel",
            customClass: {
                confirmButton: "btn btn-danger",
                cancelButton: 'btn btn-secondary'
            }
            }).then(function(result) {
                if (result.value) {
                    livewire.emit('deleteDetails',data.detail.id);
                }
            });
        });

    </script>
@endsection
{{-- end::Inject Scripts using @section --}}

