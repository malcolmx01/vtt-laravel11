{{--@extends('vtt.layouts.main')--}}
{{--@section('page','Profile')--}}
{{--@section('description','Store profile archive')--}}
{{--@section('header-component')--}}
    {{--<a href="#" class="btn kt-subheader__btn-primary">--}}
        {{--Actions &nbsp;--}}
        {{--<i class="flaticon2-calendar-1"></i>--}}
    {{--</a>--}}
{{--@endsection--}}

<x-base-layout>
{{--@section('content')--}}
<!--begin::Tables Widget 1-->
    <div class="card card-xxl-stretch mb-5 mb-xl-10">
        <!--begin::Header-->
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Profile Archive</span>
            </h3>
            <div class="card-toolbar">
                <!--begin::Menu-->
                <a href="/profiles/create" class="btn btn-brand btn-elevate btn-icon-sm">
                    <i class="la la-plus"></i>
                    Add
                </a>
                <button type="button" class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                    {!! theme()->getSvgIcon("icons/duotune/general/gen024.svg", "svg-icon-2") !!}
                </button>
            {{ theme()->getView('partials/menus/_menu-1') }}
            <!--end::Menu-->
            </div>
        </div>
        <!--end::Header-->

        <!--begin::Body-->
        <div class="card-body py-3">
            <!--begin::Table container-->
            <div class="table-responsive">
                <!-- end:: Content Head -->
                @if (count($profiles) > 0 )
                    <table class="table table-striped">
                        <tr>
                            <th>Logo</th>
                            <th>Store/Company</th>
                            <th>Location</th>
                            <th>Service</th>
                            <th colspan="3" style="text-align: center">Action</th>
                        </tr>

                        @foreach($profiles as $profile)
                            <tr>
                                <td><img style="margin:1px;width:50px;height:50px" src="/storage/profile_image/{{$profile->logo}}"></td>
                                <td>{{$profile->company}}</td>
                                <td>{{$profile->address1}}, {{$profile->address2}}</td>
                                <td>{{$profile->services}}</td>
                                <td><a href="/profiles/{{$profile->id}}" class = "btn btn-primary">View</a></td>
                                <td><a href="/profiles/{{$profile->id}}/edit" class = "btn btn-success">Edit</a></td>
                                <td>
                                    <a title="Delete" href="" class="kt-nav__link" id="remove-record"
                                       data-toggle="modal"
                                       {{--data-url= "{{route('$profile.destroy','$profile->id')}}"--}}
                                       data-id= "{{$profile->id}}"
                                       data-title= "{{$profile->company}}"
                                       data-type= "Profile"
                                       data-target="#custom-width-modal">
                                        <i class="kt-nav__link-icon flaticon2-trash"></i>
                                        <span class="kt-nav__link-text">Delete</span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        {{ $profiles->links()}}
                    </table>
                @else
                    <p>No Profile Available</p>
                @endif
            </div>
            <!--end::Table container-->
        </div>
    </div>
    <!--endW::Tables Widget 1-->
{{--@endsection--}}
    @section('modal')
    <!-- Delete Model -->
        <form action="" method="POST" class="remove-record-model">
            <div id="custom-width-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" >
                <div class="modal-dialog" style="width:55%;">
                    <div class="modal-content square shadow">
                        <div class="modal-header">
                            <h5 class="modal-title" id="custom-width-modalLabel">Confirmation</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        </div>
                        <div class="modal-body">
                            <div>
                                <p>
                                    Are you sure, you want to permanently delete Profile No. :<strong class="post-record-id">.</strong><br/><br/>
                                    Store/Company: <strong class="post-record-title"></strong>?
                                </p>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-sm btn-danger waves-effect waves-light"><span class="lnr-trash2"></span> Delete</button>
                            <button type="button" class="btn btn-sm btn-default waves-effect remove-data-from-delete-form" data-dismiss="modal"><span class="lnr-cross-circle"></span> Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endsection
</x-base-layout>

@section('scripts')

    <script>

    $(document).on('click', '#remove-record', function() {
        var id = $(this).attr('data-id');
        var url = $(this).attr('data-url');
        var title = $(this).attr('data-title');
        var type = $(this).attr('data-type');
        var token = $('meta[name="csrf-token"]').attr('content');

        $(".remove-record-model").attr("action", url);
        // console.log('ber---'+$(".remove-record-model").attr("action",url));
        $('body').find('.post-record-id').text(id);
        $('body').find('.post-record-type').text(type);
        $('body').find('.post-record-title').text(title);

        $('body').find('.remove-record-model').append('<input name="_token" type="hidden" value="' + token + '">');
        $('body').find('.remove-record-model').append('<input name="_method" type="hidden" value="delete">');
        $('body').find('.remove-record-model').append('<input name="id" type="hidden" value="' + id + '">');
    });

</script>
@endsection
