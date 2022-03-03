<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('admin.layouts.head')
    </head>
    <body class="dashboard-body">
        @include('admin.layouts.sidebar-menu')
        <main>
            <h1>@yield('page-title')</h1>
            @yield('content')
        </main>
        @include('admin.layouts.scripts')
    </body>
</html>
