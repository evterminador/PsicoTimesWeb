@extends('layouts.fc-admin')

@section('title-page', 'Dashboard')

@section('styles')
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('bower_components/Ionicons/css/ionicons.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('dist/css/skins/_all-skins.min.css') }}">
    <!-- Morris chart -->
    {{-- <link rel="stylesheet" href="{{ asset('bower_components/morris.js/morris.css') }}">
    <!-- jvectormap -->
    <link rel="stylesheet" href="{{ asset('bower_components/jvectormap/jquery-jvectormap.css') }}">
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}"> --}}
@endsection

@section('body-class', 'hold-transition skin-blue sidebar-mini')

@section('head-parts')
    @include('admin.components.head-parts')
@endsection

@section('side-main')
    @include('admin.components.side-main')
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>PsicoTimes <small>Control panel</small></h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
                <li class="active">Here</li>
            </ol>
        </section>
        <div class="content container-fluid">
            <div class="row">
                <!--First Row the users-registration-->
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>{{ $countUsersThisDay }}</h3>
                            <p>Usuarios registrados</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <!--Second Row the numbers de applications-->
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Stadisticas</h3>
                        </div>

                        <div class="box-body">
                            <table id="tableUsers" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>UserName</th>
                                    <th>Aplicación</th>
                                    <th>Cantidad de uso</th>
                                    <th>Tiempo de uso</th>
                                    <th>Ultimo acceso</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($appUsers as $app)
                                    <tr>
                                        <td>{{ App\User::find($app->user_id)->name }}</td>
                                        <td>{{ App\Application::find($app->app_id)->name_application }}</td>
                                        <td>{{ $app->quantity }}</td>
                                        <td>{{ convertLongToTimeChar($app->time_use) }}</td>
                                        <td>{{ $app->last_use_time }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('admin.components.footer')
@endsection

@section('side-bar')
    @include('admin.components.side-bar')
@endsection

@section('scripts')
    <script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
@endsection

