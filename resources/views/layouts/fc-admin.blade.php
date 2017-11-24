<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" @yield('type-web')>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title-page') | PsicoTimes</title>

        @yield('styles')
    </head>
    <body  class="@yield('body-class')">
        <div class="wrapper">
            @yield('head-parts')

            @yield('side-main')

            @yield('content')

            @yield('footer')

            @yield('side-bar')
        </div>

        <!-- Scripts -->
        @yield('scripts')
    </body>
</html>
