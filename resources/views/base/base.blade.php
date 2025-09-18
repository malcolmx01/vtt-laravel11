<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"{!! theme()->printHtmlAttributes('html') !!} {{ theme()->printHtmlClasses('html') }}>
{{-- begin::Head --}}

<head>
    <meta charset="utf-8"/>
    <title>{{ ucfirst(theme()->getOption('meta', 'title')) }}</title>
    <meta name="description" content="{{ ucfirst(theme()->getOption('meta', 'description')) }}"/>
    <meta name="keywords" content="{{ theme()->getOption('meta', 'keywords') }}"/>
    {{--<link rel="canonical" href="{{ ucfirst(theme()->getOption('meta', 'canonical')) }}"/>--}}
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="shortcut icon" href="{{ asset('favicon.png')  }}"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- edited --}}

    {{-- begin::Fonts --}}
    {{ theme()->includeFonts() }}
    {{-- end::Fonts --}}

    @if (theme()->hasOption('page', 'assets/vendors/css'))
        {{-- begin::Page Vendor Stylesheets(used by this page) --}}
        @foreach (array_unique(theme()->getOption('page', 'assets/vendors/css')) as $file)
            {!! preloadCss(assetCustom($file)) !!}
        @endforeach
        {{-- end::Page Vendor Stylesheets --}}
    @endif

    @if (theme()->hasOption('page', 'assets/custom/css'))
        {{-- begin::Page Custom Stylesheets(used by this page) --}}
        @foreach (array_unique(theme()->getOption('page', 'assets/custom/css')) as $file)
            {!! preloadCss(assetCustom($file)) !!}
        @endforeach
        {{-- end::Page Custom Stylesheets --}}
    @endif

    {{--Below lines conflicts with Select2--}}
    @if (theme()->hasOption('assets', 'css'))
         {{--begin::Global Stylesheets Bundle(used by all pages)--}}
        @foreach (array_unique(theme()->getOption('assets', 'css')) as $file)
            @if (strpos($file, 'plugins') !== false)
                <link href="{{ assetCustom($file) }}" rel="stylesheet" type="text/css"/>
                {{--{!! preloadCss(assetCustom($file)) !!}--}}
            @else
                <link href="{{ assetCustom($file) }}" rel="stylesheet" type="text/css"/>
            @endif
        @endforeach
        {{--end::Global Stylesheets Bundle--}}
    @endif

    {{--begin:: Styles--}}
    @yield('styles')
    {{ $styles ?? '' }}
    {{--end:: Styles--}}

    @livewireStyles
</head>
{{-- end::Head --}}

{{-- begin::Body --}}
<body {!! theme()->printHtmlAttributes('body') !!} {!! theme()->printHtmlClasses('body') !!} {!! theme()->printCssVariables('body') !!}>

    @if (theme()->getOption('layout', 'loader/display') === true)
        {{ theme()->getView('layout/_loader') }}
    @endif

    @yield('content')

    {{--begin:: Modal--}}
        @yield('modal')
        {{ $modal ?? '' }}
    {{--end:: Modal--}}

    {{-- begin::Javascript --}}

        {{--Below lines conflicts with Select2--}}
        @if (theme()->hasOption('assets', 'js'))
             {{-- begin::Global Javascript Bundle(used by all pages) --}}
            @foreach (array_unique(theme()->getOption('assets', 'js')) as $file)
                <script src="{{ asset(theme()->getDemo() . '/' .$file) }}"></script>
            @endforeach
             {{-- end::Global Javascript Bundle --}}
        @endif

        @if (theme()->hasOption('page', 'assets/vendors/js'))
             {{-- begin::Page Vendors Javascript(used by this page) --}}
            @foreach (array_unique(theme()->getOption('page', 'assets/vendors/js')) as $file)
                <script src="{{ asset(theme()->getDemo() . '/' .$file) }}"></script>
            @endforeach
             {{-- end::Page Vendors Javascript --}}
        @endif

        @if (theme()->hasOption('page', 'assets/custom/js'))
             {{-- begin::Page Custom Javascript(used by this page) --}}
            @foreach (array_unique(theme()->getOption('page', 'assets/custom/js')) as $file)
                <script src="{{ asset(theme()->getDemo() . '/' .$file) }}"></script>
            @endforeach
             {{-- end::Page Custom Javascript --}}
        @endif
    {{-- end::Javascript --}}

    {{--@if (theme()->getViewMode() === 'preview')--}}
        {{--{{ theme()->getView('partials/trackers/_ga-tag-manager-for-body') }}--}}
    {{--@endif--}}

    @livewireScripts
    <x-livewire-alert::scripts />

    {{--<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>--}}
    {{--<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script--}}
    {{--<script defer src="https://unpkg.com/alpinejs@3.2.4/dist/cdn.min.js"></script>--}}
    {{--<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>--}}

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/10.5.0/styles/default.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/10.5.0/highlight.min.js"></script>

    {{--//calendar begin--}}


    {{--<link href="{{ asset('wizard.css') }}" rel="stylesheet" id="bootstrap-css">--}}
    {{--//calendar end--}}

    {{--begin:: Scripts--}}
        @yield('scripts')
        {{ $scripts ?? '' }}
        @stack('scripts')
    {{--end:: Scripts--}}

    <style>
        div.table-responsive::-webkit-scrollbar {
            width: 12px;
            height: 12px;
            overflow-x:scroll;
        }
        div.table-responsive::-webkit-scrollbar-track {
            background-color:#f5f5f5;
        }

        div.table-responsive::-webkit-scrollbar-thumb {
            background: #cccccc;
            border-radius: 16px;
        }

        div.table-responsive::-webkit-scrollbar-button {
            display: block;
            background-color: #f5f5f5;
            background-repeat: no-repeat;
            background-size: 50%;
            background-position: center;
            width: 20px;
        }

        div.table-responsive::-webkit-scrollbar-button:horizontal:start:increment {
            /*background-image: url('https://upload.wikimedia.org/wikipedia/commons/3/33/Octicons-chevron-left.svg');*/
            background-image: url('https://upload.wikimedia.org/wikipedia/commons/b/b8/Font_Awesome_5_solid_chevron-left.svg');
        }

        div.table-responsive::-webkit-scrollbar-button:horizontal:start:decrement {
            display: none;
        }

        div.table-responsive::-webkit-scrollbar-button:horizontal:end:increment {
            display: none;
        }

        div.table-responsive::-webkit-scrollbar-button:horizontal:end:decrement {
            /*background-image: url('https://upload.wikimedia.org/wikipedia/commons/6/69/Octicons-chevron-right.svg');*/
            background-image: url('https://upload.wikimedia.org/wikipedia/commons/9/9d/Font_Awesome_5_solid_chevron-right.svg');
        }

    </style>

</body>
{{-- end::Body --}}
</html>
