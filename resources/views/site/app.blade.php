<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    {{-- SMO e META TAGS --}}
    @include('site.partials.smo')
    {{-- Mensagens --}}
    @include('site.partials.message')
    {{-- Favicons --}}
    @include('site.partials.favicons')
    {{-- css --}}
    @include('site.assets.css')

</head>
<body >
    {{-- Head --}}
    @include('site.partials.head')

    {{-- Body Content --}}
    @yield('body')

    {{-- Footer --}}
    @include('site.partials.footer')
    {{-- Footer --}}
    @include('site.partials.copyright')

    {{-- Custom Scripts --}}
    @include('site.assets.js')

</body>

</html>
