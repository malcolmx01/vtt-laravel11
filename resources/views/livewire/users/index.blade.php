<div>


    <!-- ********************************************************************************** -->
    <!-- *** Start: Message Box -->
    <!-- ********************************************************************************** -->

    @include('livewire.components.notification')

    <!-- ********************************************************************************** -->
    <!-- *** End: Message Box -->
    <!-- ********************************************************************************** -->

    @include('livewire.users.archive')
    @include('livewire.users.show')
    @include('livewire.users.update')


{{--{{ theme()->getView('pages/account/_navbar', array('class' => 'mb-5 mb-xl-10', 'info' => $info ?? '')) }}

{{ theme()->getView('pages/account/settings/_profile-details', array('class' => 'mb-5 mb-xl-10', 'info' => $info ?? '')) }}

{{ theme()->getView('pages/account/settings/_signin-method', array('class' => 'mb-5 mb-xl-10', 'info' => $info ?? '')) }}--}}


<!--begin::Slot for Styles-->
    <x-slot name="styles">
        <style>
            .pagination{
                justify-content: unset !important;
            }
        </style>
    </x-slot>
    <!--end::Slot for Styles-->

    <!--begin::Modal-->
    <x-slot name="modal">

    </x-slot>
    <!--end::Modal-->

    <!--begin::Scripts-->
    <x-slot name="scripts">
        {{--<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>--}}
    </x-slot>
    <!--end::Scripts-->

</div>


@section('modal')


    <!-- Begin: Modal Confirmation -->
    <div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form autocomplete="off">
                <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title">Delete Confirmation</h5>
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
                    <p>Are you sure want to delete {{ $deletedRow ?? '' }} ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    {{--<button type="button" wire:click.prevent="ber()" class="btn btn-danger close-modal" data-bs-dismiss="modal">Yes, Delete</button>--}}
                    {{--<button type="button" wire:click.prevent="delete" class="btn btn-danger close-modal">Yes, Delete</button>--}}
                    <button type="submit" wire:click.prevent="delete" class="btn btn-danger close-modal">Yes, Delete</button>
                </div>
            </div>
            </form>
        </div>
    </div>
    <!-- End: Modal Confirmation -->

@endsection



{{-- begin::Inject Scripts using @section --}}
@section('scripts')
    <script type="text/javascript">

        window.livewire.on('goToTopPage', () => {
            scrollTo({top: 0, behavior: 'smooth'});
        });

        window.livewire.on('userStore', () => {
            if ($(".modal-backdrop").length > 1) {
            $(".modal-backdrop").not(':first').remove();
        }
        $('#formCreateModal').modal('hide');
        $(".x-button").click(function(){
            $("#formCreateModal").modal('hide');
            console.log('x-button userStore');
        });
        console.log('outside userStore');
        });

        window.livewire.on('userUpdate', () => {
            if ($(".modal-backdrop").length > 1) {
            $(".modal-backdrop").not(':first').remove();
        }
        $('#formUpdateModal').modal('hide');
        $(".x-button").click(function(){
            $("#formUpdateModal").modal('hide');
            console.log('userUpdate');
        });
        console.log('outside userUpdate');
        });

        window.livewire.on('openDeleteModal', () => {
            console.log('Open delete modal');
        // $("#deleteModal").modal('show');
        });


    </script>
@endsection
{{-- end::Inject Scripts using @section --}}
