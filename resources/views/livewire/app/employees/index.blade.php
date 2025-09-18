@section('toolbar-menu')
    <!--begin::Wrapper-->
    {{--<div data-bs-toggle="tooltip" data-bs-placement="left" data-bs-trigger="hover" title="Create New Record">--}}
        {{--<a class="btn btn-sm btn-primary fw-bolder mx-1" class="archiveEmployeeModal">--}}
            {{--Archive--}}
        {{--</a>--}}
    {{--</div>--}}
    <div data-bs-toggle="tooltip" data-bs-placement="left" data-bs-trigger="hover" title="Create New Record">
        <a class="btn btn-sm btn-primary fw-bolder" class="createEmployeeModal">
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

    @include('livewire.app.employees.employees-archive')
    @include('livewire.app.employees.archive')
    @include('livewire.app.employees.form')


</div>


{{-- begin::Inject Scripts using @section --}}
@section('scripts')
    <script type="text/javascript">

        $(document).ready(function () {
            $( ".archiveEmployeeModal" ).click(function() {
                window.livewire.emit('ArchiveEmployeeRecord');
            });
            $( ".createEmployeeModal" ).click(function() {
                window.livewire.emit('CreateNewEmployeeRecord');
            });
        });

        window.addEventListener('openEmployeeArchiveModal', event => {
            $("#ListOfEmployeeModal").modal('show');
        });
        window.addEventListener('closeEmployeeArchiveModal', event => {
            $("#ListOfEmployeeModal").modal('hide');
        });

        window.addEventListener('openFormEmployeeModal', event => {
            $("#formEmployeeModal").modal('show');
        });
        window.addEventListener('closeFormEmployeeModal', event => {
            $("#formEmployeeModal").modal('hide');
        });

        window.livewire.on('goToTopPage', () => {
            scrollTo({top: 0, behavior: 'smooth'});
        });

    </script>
@endsection
{{-- end::Inject Scripts using @section --}}

