<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('general.head')
<body>
    @if(isset($metrics->body_start) && !empty($metrics->body_start))
        {!! $metrics->body_start !!}
    @endif
<div class="b-wrapper">

    @include('general.header')

    @yield('content')
</div>
    @include('general.footer')
    @include('general.fixed')
    @include('general.menus.mobile-menu')
    @include('general.validation')
    @include('general.cookie')

    @yield('scripts')

    @if(isset($metrics->body_end) && !empty($metrics->body_end))
        {!! $metrics->body_end !!}
    @endif

    @yield('schema_org')
</body>
