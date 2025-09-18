{{--begin::Aside Menu--}}
@php
    $menu = bootstrap()->getAsideMenu();
    \App\Core\Adapters\Menu::filterMenuPermissions($menu->items);
@endphp

<div
        class="hover-scroll-overlay-y my-5 my-lg-5"
        id="kt_aside_menu_wrapper"
        data-kt-scroll="true"
        data-kt-scroll-activate="{default: false, lg: true}"
        data-kt-scroll-height="auto"
        data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer"
        data-kt-scroll-wrappers="#kt_aside_menu"
        data-kt-scroll-offset="0"
>
    {{-- edited --}}
    {{--begin::Menu--}}
    <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500" id="#kt_aside_menu" data-kt-menu="true">
        <div class="menu-item">
            <a class="menu-link active" href="{{ url('/') }}">
                <span class="menu-icon">
                    <span class="svg-icon svg-icon-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
                            <path opacity="0.3" d="M8.9 21L7.19999 22.6999C6.79999 23.0999 6.2 23.0999 5.8 22.6999L4.1 21H8.9ZM4 16.0999L2.3 17.8C1.9 18.2 1.9 18.7999 2.3 19.1999L4 20.9V16.0999ZM19.3 9.1999L15.8 5.6999C15.4 5.2999 14.8 5.2999 14.4 5.6999L9 11.0999V21L19.3 10.6999C19.7 10.2999 19.7 9.5999 19.3 9.1999Z" fill="black"></path>
                            <path d="M21 15V20C21 20.6 20.6 21 20 21H11.8L18.8 14H20C20.6 14 21 14.4 21 15ZM10 21V4C10 3.4 9.6 3 9 3H4C3.4 3 3 3.4 3 4V21C3 21.6 3.4 22 4 22H9C9.6 22 10 21.6 10 21ZM7.5 18.5C7.5 19.1 7.1 19.5 6.5 19.5C5.9 19.5 5.5 19.1 5.5 18.5C5.5 17.9 5.9 17.5 6.5 17.5C7.1 17.5 7.5 17.9 7.5 18.5Z" fill="black"></path>
                        </svg>
                    </span>
                </span>
                <span class="menu-title">Dashboard</span>
            </a>
        </div>
        <div class="menu-item">
            <div class="menu-content pt-8 pb-2">
                <span class="menu-section text-muted text-uppercase fs-8 ls-1">VTT</span>
            </div>
        </div>

        <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
            <span class="menu-link">
                <span class="menu-icon">
                    <!--begin::Svg Icon | path: assets/media/icons/duotune/ecommerce/ecm006.svg-->
                    <span class="svg-icon svg-icon-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M20 8H16C15.4 8 15 8.4 15 9V16H10V17C10 17.6 10.4 18 11 18H16C16 16.9 16.9 16 18 16C19.1 16 20 16.9 20 18H21C21.6 18 22 17.6 22 17V13L20 8Z" fill="currentColor"/>
                            <path opacity="0.3" d="M20 18C20 19.1 19.1 20 18 20C16.9 20 16 19.1 16 18C16 16.9 16.9 16 18 16C19.1 16 20 16.9 20 18ZM15 4C15 3.4 14.6 3 14 3H3C2.4 3 2 3.4 2 4V13C2 13.6 2.4 14 3 14H15V4ZM6 16C4.9 16 4 16.9 4 18C4 19.1 4.9 20 6 20C7.1 20 8 19.1 8 18C8 16.9 7.1 16 6 16Z" fill="currentColor"/>
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </span>
                <span class="menu-title">VTT</span>
                <span class="menu-arrow"></span>
            </span>
            <div class="menu-sub menu-sub-accordion menu-active-bg">
                <div class="menu-item">
                    <a class="menu-link" href="{{route('vtt.trips')}}">
                        <span class="menu-bullet">
                            <span class="bullet bullet-dot"></span>
                        </span>
                        <span class="menu-title">Trip Ticket</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link" href="{{route('vtt.topups')}}">
                        <span class="menu-bullet">
                            <span class="bullet bullet-dot"></span>
                        </span>
                        <span class="menu-title">Top Up</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link" href="{{route('vtt.vehicles')}}">
                        <span class="menu-bullet">
                            <span class="bullet bullet-dot"></span>
                        </span>
                        <span class="menu-title">Vehicle</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="menu-item">
            <div class="menu-content pt-8 pb-2">
                <span class="menu-section text-muted text-uppercase fs-8 ls-1">Reports</span>
            </div>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="{{route('app.reports')}}">
                <span class="menu-icon">
                    <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2022-08-18-143101/core/html/src/media/icons/duotune/graphs/gra004.svg-->
                     <span class="svg-icon svg-icon-2"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.3" d="M11 11H13C13.6 11 14 11.4 14 12V21H10V12C10 11.4 10.4 11 11 11ZM16 3V21H20V3C20 2.4 19.6 2 19 2H17C16.4 2 16 2.4 16 3Z" fill="currentColor"/>
                    <path d="M21 20H8V16C8 15.4 7.6 15 7 15H5C4.4 15 4 15.4 4 16V20H3C2.4 20 2 20.4 2 21C2 21.6 2.4 22 3 22H21C21.6 22 22 21.6 22 21C22 20.4 21.6 20 21 20Z" fill="currentColor"/>
                    </svg></span>
                    <!--end::Svg Icon-->

                </span>

                <span class="menu-title">Reports</span>
            </a>
        </div>
        <div class="menu-item">
            <div class="menu-content pt-8 pb-2">
                <span class="menu-section text-muted text-uppercase fs-8 ls-1">Administrator</span>
            </div>
        </div>
        {!! $menu->build() !!}
    </div>
    {{--end::Menu--}}
</div>
{{--end::Aside Menu--}}
