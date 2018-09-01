<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <meta name="description" content="@yield('meta-description')">
    <meta name="keywords" content="@yield('meta-keywords')">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/simple-line-icons/css/simple-line-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/font-awesome/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/profile.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css"/>
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/trumbowyg/dist/ui/trumbowyg.min.css')}}">
    <style>
        .dropdown-toggle.no-after:after {
            content: none;
        }

        .dropdown-item.no-hover:hover {
            background-color: transparent;
        }
    </style>
</head>
<body class="sidebar-fixed header-fixed">
<div class="page-wrapper">
    <div id="app">
        @include('includes.admin.headerNavigation')
    </div>
    <div class="main-container">
        @include('includes.user.sidebarNavigation')
        <div class="content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
    </div>
</div>
@include('includes.admin.scripts')
<script src="{{ asset('js/app.js') }}" defer></script>
@yield('scripts')
</body>
</html>