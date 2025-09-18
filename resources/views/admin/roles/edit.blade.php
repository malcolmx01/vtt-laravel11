@section('pageTitle','Roles')
@section('pageDescription','Edit Role')

@section('toolbar-menu')
    <a href="{{ route('admin.roles.index') }}" class="btn btn-sm btn-flex btn-light btn-active-primary fw-bolder">
        Role Archive
    </a>
@endsection

<x-base-layout>

    <!-- ********************************************************************************** -->
    <!-- *** Start: Message Box -->
    <!-- ********************************************************************************** -->

    @include('livewire.components.notification')

    <!-- ********************************************************************************** -->
    <!-- *** End: Message Box -->
    <!-- ********************************************************************************** -->

    <div class="card card-p-35 card-flush">

        <!--begin::card-header-->
        <div class="card-header align-items-center gap-2 gap-md-5 pt-15 px-10 pt-lg-15 px-lg-15">
            <!--begin::card-title-->
            <h3 class="card-title">Edit Role</h3>
            <!--end::card-title-->
        </div>
        <!--end::card-header-->

        <!--begin::card-body-->
        <div class="card-body pe-15 px-10 pe-lg-15 px-lg-15">
           <div class="row">
               <div class="col-md-12">
                   <form method="POST" action="{{ route('admin.roles.update', $role->id) }}" class="mb-8">
                       @csrf
                       @method('PUT')
                       <div class="row">
                           <div class="col-md-10 mb-3">
                               <label for="name" class="form-label required">Role name</label>
                               <input type="text" id="name" name="name" value="{{ $role->name }}" class="form-control form-control-solid">
                               @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                           </div>
                           <div class="d-grid gap-2 mx-auto col-md-2 mb-3">
                               <label class="form-label"></label>
                               <button type="submit" class="btn btn-primary py-md-1">Update</button>
                           </div>
                       </div>
                   </form>
               </div>
           </div>
            <div class="separator mb-10"></div>
            <div class="row">
                <div class="col-md-6 mb-5">
                    <div class="card card-flush shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Role Permissions</h3>
                        </div>
                        <div class="card-body py-5">
                            @if ($role->permissions)
                                <div class="row row-cols-auto">
                                    @forelse ($role->permissions as $role_permission)
                                        <div class="col">
                                            <form method="POST"
                                                  action="{{ route('admin.roles.permissions.revoke', [$role->id, $role_permission->id]) }}"
                                                  onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline btn-outline-dashed btn-outline-primary btn-active-light-primary mb-3">{{ $role_permission->name }}</button>
                                            </form>
                                        </div>
                                    @empty
                                        <div class="col">
                                            <i>No Permission</i>
                                        </div>
                                    @endforelse
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-5">
                    <div class="card card-flush shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Assign Permission</h3>
                        </div>
                        <div class="card-body py-5">
                            <form method="POST" action="{{ route('admin.roles.permissions', $role->id) }}">
                                @csrf
                                <label for="permission" class="form-label">Select Permission</label>
                                <div class="input-group mb-10">
                                    <select id="permission" name="permission" autocomplete="permission-name"
                                            class="form-select form-select-solid">
                                        @foreach ($permissions as $permission)
                                            <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-primary">Assign</button>
                                </div>
                                @error('permission')
                                 <span class="text-red-400 text-sm">{{ $message }}</span>
                                @enderror
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!--end::card-body-->

    </div>
</x-base-layout>
