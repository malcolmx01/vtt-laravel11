@section('pageTitle','Permissions')
@section('pageDescription','Edit Permission')


@section('toolbar-menu')
    <a href="{{ route('admin.permissions.index')  }}" class="btn btn-sm btn-flex btn-light btn-active-primary fw-bolder">
        Permission Archive
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
            <h3 class="card-title">Edit Permission</h3>
            <!--end::card-title-->
        </div>
        <!--end::card-header-->

        <!--begin::card-body-->
        <div class="card-body pe-15 px-10 pe-lg-15 px-lg-15">
            <div class="row">
                <div class="col-md-12">
                    <form method="POST" action="{{ route('admin.permissions.update', $permission) }}" class="mb-8">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-10 mb-3">
                                <label for="name" class="form-label required">Permission name</label>
                                <input type="text" id="name" name="name" value="{{ $permission->name }}" class="form-control form-control-solid">
                                @error('name') <span>{{ $message }}</span> @enderror
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
                            <h3 class="card-title">Roles</h3>
                        </div>
                        <div class="card-body py-5">
                            @if ($permission->roles)
                                <div class="row row-cols-auto">
                                    @forelse ($permission->roles as $permission_role)
                                        <div class="col">
                                            <form method="POST"
                                                  action="{{ route('admin.permissions.roles.remove', [$permission->id, $permission_role->id]) }}"
                                                  onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline btn-outline-dashed btn-outline-primary btn-active-light-primary mb-3">{{ $permission_role->name }}</button>
                                            </form>
                                        </div>
                                    @empty
                                        <div class="col">
                                            <i>No Role Assigned</i>
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
                            <h3 class="card-title">Assign Roles</h3>
                        </div>
                        <div class="card-body py-5">
                            <form method="POST" action="{{ route('admin.permissions.roles', $permission->id) }}">
                                @csrf
                                <label for="role" class="form-label">Select Roles</label>
                                <div class="input-group mb-10">
                                    <select id="role" name="role" autocomplete="role-name"
                                            class="form-select form-select-solid">
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-primary">Assign</button>
                                </div>
                                @error('role')
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

    {{--<div class="py-12 w-full">--}}
        {{--<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">--}}
            {{--<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-2">--}}
                {{--<div class="flex p-2">--}}
                    {{--<a href="{{ route('admin.permissions.index') }}"--}}
                        {{--class="px-4 py-2 bg-green-700 hover:bg-green-500 text-slate-100 rounded-md">Permission Index</a>--}}
                {{--</div>--}}
                {{--<div class="flex flex-col p-2 bg-slate-100">--}}
                    {{--<div class="space-y-8 divide-y divide-gray-200 w-1/2 mt-10">--}}
                        {{--<form method="POST" action="{{ route('admin.permissions.update', $permission) }}">--}}
                            {{--@csrf--}}
                            {{--@method('PUT')--}}
                            {{--<div class="sm:col-span-6">--}}
                                {{--<label for="name" class="block text-sm font-medium text-gray-700"> Permission name--}}
                                {{--</label>--}}
                                {{--<div class="mt-1">--}}
                                    {{--<input type="text" id="name" name="name"--}}
                                        {{--class="block w-full appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5"--}}
                                        {{--value="{{ $permission->name }}" />--}}
                                {{--</div>--}}
                                {{--@error('name')--}}
                                    {{--<span class="text-red-400 text-sm">{{ $message }}</span>--}}
                                {{--@enderror--}}
                            {{--</div>--}}
                            {{--<div class="sm:col-span-6 pt-5">--}}
                                {{--<button type="submit"--}}
                                    {{--class="px-4 py-2 bg-green-500 hover:bg-green-700 rounded-md">Update</button>--}}
                            {{--</div>--}}
                        {{--</form>--}}
                    {{--</div>--}}

                {{--</div>--}}
                {{--<div class="mt-6 p-2 bg-slate-100">--}}
                    {{--<h2 class="text-2xl font-semibold">Roles</h2>--}}
                    {{--<div class="flex space-x-2 mt-4 p-2">--}}
                        {{--@if ($permission->roles)--}}
                            {{--@foreach ($permission->roles as $permission_role)--}}
                                {{--<form class="px-4 py-2 bg-red-500 hover:bg-red-700 text-white rounded-md" method="POST"--}}
                                    {{--action="{{ route('admin.permissions.roles.remove', [$permission->id, $permission_role->id]) }}"--}}
                                    {{--onsubmit="return confirm('Are you sure?');">--}}
                                    {{--@csrf--}}
                                    {{--@method('DELETE')--}}
                                    {{--<button type="submit">{{ $permission_role->name }}</button>--}}
                                {{--</form>--}}
                            {{--@endforeach--}}
                        {{--@endif--}}
                    {{--</div>--}}
                    {{--<div class="max-w-xl mt-6">--}}
                        {{--<form method="POST" action="{{ route('admin.permissions.roles', $permission->id) }}">--}}
                            {{--@csrf--}}
                            {{--<div class="sm:col-span-6">--}}
                                {{--<label for="role" class="block text-sm font-medium text-gray-700">Roles</label>--}}
                                {{--<select id="role" name="role" autocomplete="role-name"--}}
                                    {{--class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">--}}
                                    {{--@foreach ($roles as $role)--}}
                                        {{--<option value="{{ $role->name }}">{{ $role->name }}</option>--}}
                                    {{--@endforeach--}}
                                {{--</select>--}}
                            {{--</div>--}}
                            {{--@error('role')--}}
                                {{--<span class="text-red-400 text-sm">{{ $message }}</span>--}}
                            {{--@enderror--}}
                    {{--</div>--}}
                    {{--<div class="sm:col-span-6 pt-5">--}}
                        {{--<button type="submit"--}}
                            {{--class="px-4 py-2 bg-green-500 hover:bg-green-700 rounded-md">Assign</button>--}}
                    {{--</div>--}}
                    {{--</form>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
</x-base-layout>
