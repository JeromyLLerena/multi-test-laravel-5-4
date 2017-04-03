<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>
        @section('title')
            Virgin Mobile Admin
        @show
        </title>

        <!-- Bootstrap Core CSS -->
        <link href="{{asset('assets/startbootstrap-sb-admin-2-1.0.8/bower_components/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="{{asset('assets/startbootstrap-sb-admin-2-1.0.8/bower_components/metisMenu/dist/metisMenu.min.css')}}" rel="stylesheet">

        <!-- Timeline CSS -->
        <link href="{{asset('assets/startbootstrap-sb-admin-2-1.0.8/dist/css/timeline.css')}}" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="{{asset('assets/startbootstrap-sb-admin-2-1.0.8/dist/css/sb-admin-2.css')}}" rel="stylesheet">

        <!-- Morris Charts CSS -->
        <link href="{{asset('assets/startbootstrap-sb-admin-2-1.0.8/bower_components/morrisjs/morris.css')}}" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="{{asset('assets/startbootstrap-sb-admin-2-1.0.8/bower_components/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">

        @yield('extra_css')
    </head>

    @section('body_tag')
    <body>
    @show
        <div id="wrapper">
            @include('layouts.admin.navigation')
            <div id="page-wrapper" class="container-fluid">
                @yield('content')
            </div>
        </div>

    <!-- jQuery -->
    <script src="{{asset('assets/startbootstrap-sb-admin-2-1.0.8/bower_components/jquery/dist/jquery.min.js')}}"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="{{asset('assets/startbootstrap-sb-admin-2-1.0.8/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="{{asset('assets/startbootstrap-sb-admin-2-1.0.8/bower_components/metisMenu/dist/metisMenu.min.js')}}"></script>

    <!-- Morris Charts JavaScript -->
    <script src="{{asset('assets/startbootstrap-sb-admin-2-1.0.8/bower_components/raphael/raphael-min.js')}}"></script>
    <!--
    <script src="{{asset('assets/startbootstrap-sb-admin-2-1.0.8/bower_components/morrisjs/morris.min.js')}}"></script>
    <script src="{{asset('assets/startbootstrap-sb-admin-2-1.0.8/js/morris-data.js')}}"></script>
    -->

    <!-- Custom Theme JavaScript -->
    <script src="{{asset('assets/startbootstrap-sb-admin-2-1.0.8/dist/js/sb-admin-2.js')}}"></script>

        @yield('extra_scripts')
    </body>
</html>