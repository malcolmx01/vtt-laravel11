@section('pageTitle','Permissions')
@section('pageDescription','Create Permissions')


@section('toolbar-menu')
    <a href="{{ route('admin.permissions.index')  }}" class="btn btn-sm btn-flex btn-light btn-active-primary fw-bolder">
        Permission Archive
    </a>
@endsection

<x-base-layout>

    <div class="card card-p-35 card-flush">

        <!--begin::card-header-->
        <div class="card-header align-items-center gap-2 gap-md-5 pt-15 px-10 pt-lg-15 px-lg-15">
            <!--begin::card-title-->
            <h3 class="card-title">Create Permission</h3>
            <!--end::card-title-->
        </div>
        <!--end::card-header-->

        <!--begin::card-body-->
        <div class="card-body pe-15 px-10 pe-lg-15 px-lg-15">
            <form method="POST" action="{{ route('admin.permissions.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-10 mb-3">
                        <label for="name" class="form-label required">Permission name</label>
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

    {{--<div class="py-12 w-full">--}}
        {{--<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">--}}
            {{--<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-2">--}}
                {{--<div class="flex p-2">--}}
                    {{--<a href="{{ route('admin.permissions.index') }}" class="px-4 py-2 bg-green-700 hover:bg-green-500 text-slate-100 rounded-md">Permission Index</a>--}}
                {{--</div>--}}
                {{--<div class="flex flex-col">--}}
                    {{--<div class="space-y-8 divide-y divide-gray-200 w-1/2 mt-10">--}}
                        {{--<form method="POST" action="{{ route('admin.permissions.store') }}">--}}
                            {{--@csrf--}}
                          {{--<div class="sm:col-span-6">--}}
                            {{--<label for="name" class="block text-sm font-medium text-gray-700"> Post name </label>--}}
                            {{--<div class="mt-1">--}}
                              {{--<input type="text" id="name" name="name" class="block w-full appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5" />--}}
                            {{--</div>--}}
                            {{--@error('name') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror--}}
                          {{--</div>--}}
                          {{--<div class="sm:col-span-6 pt-5">--}}
                            {{--<button type="submit" class="px-4 py-2 bg-green-500 hover:bg-green-700 rounded-md">Create</button>--}}
                          {{--</div>--}}
                        {{--</form>--}}
                      {{--</div>--}}

                {{--</div>--}}

            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
</x-base-layout>
