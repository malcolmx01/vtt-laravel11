@php
    $menu = bootstrap()->getHorizontalMenu();
    \App\Core\Adapters\Menu::filterMenuPermissions($menu->items);
@endphp

    <!--begin::Menu wrapper-->
<div class="header-menu align-items-stretch"
     data-kt-drawer="true"
     data-kt-drawer-name="header-menu"
     data-kt-drawer-activate="{default: true, lg: false}"
     data-kt-drawer-overlay="true"
     data-kt-drawer-width="{default:'200px', '300px': '250px'}"
     data-kt-drawer-direction="end"
     data-kt-drawer-toggle="#kt_header_menu_mobile_toggle"
     data-kt-swapper="true"
     data-kt-swapper-mode="prepend"
     data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header_nav'}"
>
    <!--begin::Menu-->
    <div
        class="menu menu-lg-rounded menu-column menu-lg-row menu-state-bg menu-title-gray-700 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-400 fw-bold my-5 my-lg-0 align-items-stretch"
        id="#kt_header_menu"
        data-kt-menu="true"
    >
{{--        <div class="menu-item me-lg-1">--}}
{{--            <a class="menu-link py-3 {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ url('/') }}">--}}
{{--                <span class="menu-title">Dashboard</span>--}}
{{--            </a>--}}
{{--        </div>--}}

        {!! $menu->build() !!}

        <div data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start"
             class="menu-item menu-lg-down-accordion me-lg-1">
            <span class="menu-link py-3">
                <span class="menu-title">VTT</span>
                <span class="menu-arrow d-lg-none"></span>
            </span>
            <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown w-100 w-lg-900px p-5 p-lg-5">
                <!--begin:Row-->
                <div class="row" data-kt-menu-dismiss="true">
                    <!--begin:Col-->
                    <div class="col-lg-3 border-left-lg-1">
                        <div class="menu-inline menu-column menu-active-bg">
                            <div class="menu-item">
                                <a href="{{route('vtt.trips')}}" class="menu-link">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: assets/media/icons/duotune/ecommerce/ecm006.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none">
                                                <path
                                                    d="M20 8H16C15.4 8 15 8.4 15 9V16H10V17C10 17.6 10.4 18 11 18H16C16 16.9 16.9 16 18 16C19.1 16 20 16.9 20 18H21C21.6 18 22 17.6 22 17V13L20 8Z"
                                                    fill="currentColor"/>
                                                <path opacity="0.3"
                                                      d="M20 18C20 19.1 19.1 20 18 20C16.9 20 16 19.1 16 18C16 16.9 16.9 16 18 16C19.1 16 20 16.9 20 18ZM15 4C15 3.4 14.6 3 14 3H3C2.4 3 2 3.4 2 4V13C2 13.6 2.4 14 3 14H15V4ZM6 16C4.9 16 4 16.9 4 18C4 19.1 4.9 20 6 20C7.1 20 8 19.1 8 18C8 16.9 7.1 16 6 16Z"
                                                      fill="currentColor"/>
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-title">Trip Ticket</span>
                                </a>
                            </div>

                            <div class="menu-item">
                                <a href="{{route('vtt.topups')}}" class="menu-link">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: assets/media/icons/duotune/ecommerce/ecm006.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none">
                                                <path
                                                    d="M20 8H16C15.4 8 15 8.4 15 9V16H10V17C10 17.6 10.4 18 11 18H16C16 16.9 16.9 16 18 16C19.1 16 20 16.9 20 18H21C21.6 18 22 17.6 22 17V13L20 8Z"
                                                    fill="currentColor"/>
                                                <path opacity="0.3"
                                                      d="M20 18C20 19.1 19.1 20 18 20C16.9 20 16 19.1 16 18C16 16.9 16.9 16 18 16C19.1 16 20 16.9 20 18ZM15 4C15 3.4 14.6 3 14 3H3C2.4 3 2 3.4 2 4V13C2 13.6 2.4 14 3 14H15V4ZM6 16C4.9 16 4 16.9 4 18C4 19.1 4.9 20 6 20C7.1 20 8 19.1 8 18C8 16.9 7.1 16 6 16Z"
                                                      fill="currentColor"/>
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-title">Top Up</span>
                                </a>
                            </div>

                            <div class="menu-item">
                                <a href="{{route('vtt.vehicles')}}" class="menu-link">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: assets/media/icons/duotune/ecommerce/ecm006.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none">
                                                <path
                                                        d="M20 8H16C15.4 8 15 8.4 15 9V16H10V17C10 17.6 10.4 18 11 18H16C16 16.9 16.9 16 18 16C19.1 16 20 16.9 20 18H21C21.6 18 22 17.6 22 17V13L20 8Z"
                                                        fill="currentColor"/>
                                                <path opacity="0.3"
                                                      d="M20 18C20 19.1 19.1 20 18 20C16.9 20 16 19.1 16 18C16 16.9 16.9 16 18 16C19.1 16 20 16.9 20 18ZM15 4C15 3.4 14.6 3 14 3H3C2.4 3 2 3.4 2 4V13C2 13.6 2.4 14 3 14H15V4ZM6 16C4.9 16 4 16.9 4 18C4 19.1 4.9 20 6 20C7.1 20 8 19.1 8 18C8 16.9 7.1 16 6 16Z"
                                                      fill="currentColor"/>
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-title">Vehicle</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!--end:Col-->
                </div>
                <!--end:Row-->
            </div>
        </div>
    </div>
    <!--end::Menu-->
</div>
<!--end::Menu wrapper-->
