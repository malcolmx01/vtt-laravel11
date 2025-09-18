@section('pageTitle','Roles')
@section('pageDescription','Create Role')

@section('toolbar-menu')
    <a href="{{ route('admin.roles.index') }}" class="btn btn-sm btn-flex btn-light btn-active-primary fw-bolder">
        Role Archive
    </a>
@endsection

<x-base-layout>

    <div class="card card-p-35 card-flush">

        <!--begin::card-header-->
        <div class="card-header align-items-center gap-2 gap-md-5 pt-15 px-10 pt-lg-15 px-lg-15">
            <!--begin::card-title-->
            <h3 class="card-title">Create Role</h3>
            <!--end::card-title-->
        </div>
        <!--end::card-header-->

        <!--begin::card-body-->
        <div class="card-body pe-15 px-10 pe-lg-15 px-lg-15">
            <form method="POST" action="{{ route('admin.roles.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-10 mb-3">
                        <label for="name" class="form-label required">Role name</label>
                        <input type="text" id="name" name="name" class="form-control form-control-solid">
                        @error('name') <span>{{ $message }}</span> @enderror
                    </div>
                    <div class="d-grid gap-2 mx-auto col-md-2 mb-3">
                        <label class="form-label"></label>
                        <button type="submit" class="btn btn-primary py-md-1">Save</button>
                    </div>
                </div>
            </form>
        </div>
        <!--end::card-body-->

    </div>
</x-base-layout>
