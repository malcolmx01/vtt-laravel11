@section('pageTitle','Roles')
@section('pageDescription','Roles Archive')


@section('toolbar-menu')
    <a href="{{ '/admin/users' }}" class="btn btn-sm btn-flex btn-light btn-active-primary fw-bolder">
        Users Archive
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
            <h3 class="card-title">User Roles and Permissions</h3>
            <!--end::card-title-->
        </div>
        <!--end::card-header-->

        <!--begin::card-body-->
        <div class="card-body pe-15 px-10 pe-lg-15 px-lg-15">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-flush shadow-sm mb-8">
                        <div class="card-body py-10">
                            <div class="row mb-2">
                                <div class="col-2 text-end">User Name : </div>
                                <div class="col-10"><strong>{{ $user->name }}</strong></div>
                            </div>
                            <div class="row">
                                <div class="col-2 text-end">User Email : </div>
                                <div class="col-10"><strong>{{ $user->email }}</strong></div>
                            </div>
                            <table class="table table-rounded table-row-gray-200 align-middle gs-7 gy-4 d-none">
                                <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <th style="width: 120px;" class="text-end">User Name :</th>
                                    <td><strong>{{ $user->name }}</strong></td>
                                </tr>
                                <tr>
                                    <th class="text-end">User Email :</th>
                                    <td><strong>{{ $user->email }}</strong></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            {{--<div class="separator mb-10"></div>--}}
            <div class="row">
                <div class="col-md-6 mb-5">
                    <div class="card card-flush shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Roles</h3>
                        </div>
                        <div class="card-body py-5">
                            @if ($user->roles)
                                <div class="row row-cols-auto">
                                    @forelse ($user->roles as $user_role)
                                        <div class="col">
                                            <form method="POST"
                                                  action="{{ route('admin.users.roles.remove', [$user->id, $user_role->id]) }}"
                                                  onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline btn-outline-dashed btn-outline-primary btn-active-light-primary mb-3">{{ $user_role->name }}</button>
                                            </form>
                                        </div>
                                    @empty
                                        <div class="col">
                                            <i>No Role Assigned</i>
                                        </div>
                                    @endforelse
                                </div>
                            @endif
                            <div class="separator my-10"></div>
                            <div class="row">
                                <div class="col">
                                    <form method="POST" action="{{ route('admin.users.roles', $user->id) }}">
                                        @csrf
                                        <label for="role" class="form-label">Assign Roles</label>
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
                <div class="col-md-6 mb-5">
                    <div class="card card-flush shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Permissions</h3>
                        </div>
                        <div class="card-body py-5">
                            @if ($user->permissions)
                                <div class="row row-cols-auto">
                                    @forelse ($user->permissions as $user_permission)
                                        <div class="col">
                                            <form method="POST"
                                                  action="{{ route('admin.users.permissions.revoke', [$user->id, $user_permission->id]) }}"
                                                  onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline btn-outline-dashed btn-outline-primary btn-active-light-primary mb-3">{{ $user_permission->name }}</button>
                                            </form>
                                        </div>
                                    @empty
                                        <div class="col">
                                            <i>No Permission Assigned</i>
                                        </div>
                                    @endforelse
                                </div>
                            @endif

                            <div class="separator my-10"></div>

                            <div class="row">
                                <div class="col">
                                    <form method="POST" action="{{ route('admin.users.permissions', $user->id) }}">
                                        @csrf
                                        <label for="permission" class="form-label">Assign Permission</label>
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
            </div>

        </div>
        <!--end::card-body-->

    </div>


    {{--<div class="py-12 w-full">--}}
        {{--<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">--}}
            {{--<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-2">--}}
                {{--<div class="flex p-2">--}}
                    {{--<a href="{{ route('admin.users.index') }}"--}}
                        {{--class="px-4 py-2 bg-green-700 hover:bg-green-500 text-slate-100 rounded-md">Users Index</a>--}}
                    {{--<a href="{{ '/admin/users' }}"--}}
                       {{--class="px-4 py-2 bg-green-700 hover:bg-green-500 text-slate-100 rounded-md">Users Index</a>--}}
                {{--</div>--}}
                {{--<div class="flex flex-col p-2 bg-slate-100">--}}
                    {{--<div>User Name: {{ $user->name }}</div>--}}
                    {{--<div>User Email: {{ $user->email }}</div>--}}
                {{--</div>--}}
                {{--<div class="mt-6 p-2 bg-slate-100">--}}
                    {{--<h2 class="text-2xl font-semibold">Roles</h2>--}}
                    {{--<div class="flex space-x-2 mt-4 p-2">--}}
                        {{--@if ($user->roles)--}}
                            {{--@foreach ($user->roles as $user_role)--}}
                                {{--<form class="px-4 py-2 bg-red-500 hover:bg-red-700 text-white rounded-md" method="POST"--}}
                                      {{--action="{{ route('admin.users.roles.remove', [$user->id, $user_role->id]) }}"--}}
                                      {{--onsubmit="return confirm('Are you sure?');">--}}
                                    {{--@csrf--}}
                                    {{--@method('DELETE')--}}
                                    {{--<button type="submit">{{ $user_role->name }}</button>--}}
                                {{--</form>--}}
                            {{--@endforeach--}}
                        {{--@endif--}}
                    {{--</div>--}}
                    {{--<div class="max-w-xl mt-6">--}}
                        {{--<form method="POST" action="{{ route('admin.users.roles', $user->id) }}">--}}
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
                {{--<div class="mt-6 p-2 bg-slate-100">--}}
                    {{--<h2 class="text-2xl font-semibold">Permissions</h2>--}}
                    {{--<div class="flex space-x-2 mt-4 p-2">--}}
                        {{--@if ($user->permissions)--}}
                            {{--@foreach ($user->permissions as $user_permission)--}}
                                {{--<form class="px-4 py-2 bg-red-500 hover:bg-red-700 text-white rounded-md" method="POST"--}}
                                      {{--action="{{ route('admin.users.permissions.revoke', [$user->id, $user_permission->id]) }}"--}}
                                      {{--onsubmit="return confirm('Are you sure?');">--}}
                                    {{--@csrf--}}
                                    {{--@method('DELETE')--}}
                                    {{--<button type="submit">{{ $user_permission->name }}</button>--}}
                                {{--</form>--}}
                            {{--@endforeach--}}
                        {{--@endif--}}
                    {{--</div>--}}
                    {{--<div class="max-w-xl mt-6">--}}
                        {{--<form method="POST" action="{{ route('admin.users.permissions', $user->id) }}">--}}
                            {{--@csrf--}}
                            {{--<div class="sm:col-span-6">--}}
                                {{--<label for="permission"--}}
                                       {{--class="block text-sm font-medium text-gray-700">Permission</label>--}}
                                {{--<select id="permission" name="permission" autocomplete="permission-name"--}}
                                        {{--class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">--}}
                                    {{--@foreach ($permissions as $permission)--}}
                                        {{--<option value="{{ $permission->name }}">{{ $permission->name }}</option>--}}
                                    {{--@endforeach--}}
                                {{--</select>--}}
                            {{--</div>--}}
                            {{--@error('name')--}}
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

