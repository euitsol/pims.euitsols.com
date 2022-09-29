<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title> @yield('title', 'Polytechnic Information Managenment System') - Polytechnic Information Managenment System </title>

    <!-- Favicon-->
    <link rel="icon" href="" type="image/png">

    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous"/>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/custom/table.css') }}" rel="stylesheet">

    @stack('third_party_stylesheets')

    @stack('page_css')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <!-- Main Header -->
    @include('partial.nav')
    <!-- Left side column. contains the logo and sidebar -->
    @include('partial.sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper  py-5 px-5">
        @yield('content')
    </div>

    <!-- Main Footer -->
    @include('partial.footer')
</div>

<script src="{{ mix('js/app.js') }}"></script>
<script src="{{ asset('assets/js/custom-functions.js') }}"></script>
@stack('third_party_scripts')

<script src="{{ asset('assets/js/custom.js') }}"></script>

@stack('page_scripts')
</body>
</html>
