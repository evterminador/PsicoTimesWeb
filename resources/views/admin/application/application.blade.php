@extends('layouts.fc-admin')

@section('title-page', 'Applicaciones')

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
    <!-- jvectormap -->
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
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
            <h1>Applicaciones <small>Control panel</small></h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
                <li class="active">Aplicaciones</li>
            </ol>
        </section>
        <div class="content container-fluid">
            <div class="row">
                <!--First Row the users-registration-->
                <section class="col-lg-7 connectedSortable ui-sortable">
                    <div class="box box-{{ isset($message) ? 'success' : 'info'}}">
                        <div class="box-header">
                            <i class="fa fa-gear"></i>

                            <h3 class="box-title">Nueva aplicacion</h3>
                            <!-- tools box -->
                            <div class="pull-right box-tools">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                    <i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip"
                                        title="Remove">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body">
                            <form id="appForm" action="{{ route(isset($findApp) ? 'application.edit' : 'application.submit') }}" method="POST">
                                {{ csrf_field() }}

                                <input type="hidden" name="id" value="{{ isset($findApp) ? $findApp->id : '' }}">

                                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                    <label for="form1">Nombre de la aplicación: </label>
                                    <input type="text" name="name" id="form1" class="form-control" placeholder="Ejemplo: Facebook" value="{{ old('name') }}" required>
                                    @if ($errors->has('name'))
                                        <p class="help-block">{{ $errors->first('name') }}</p>
                                    @endif
                                </div>
                                <div class="form-group {{ $errors->has('relevance') ? 'has-error' : '' }}">
                                    <label for="form2">Relevancia: </label>
                                    <input type="text" name="relevance" id="form2" class="form-control" placeholder="(10:Alta)...(1:Baja)" value="{{ old('relevance') }}" required>
                                    @if ($errors->has('relevance'))
                                        <p class="help-block">{{ $errors->first('relevance') }}</p>
                                    @endif
                                </div>
                                <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                                    <label for="form3">Ruta de la imagen: </label>
                                    <input type="text" name="image" id="form3" class="form-control" placeholder="http://lorempixel.com/400/200/..." value="{{ old('image') }}" required>
                                    @if ($errors->has('image'))
                                        <p class="help-block">{{ $errors->first('image') }}</p>
                                    @endif
                                </div>
                                <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                                    <label for="form4">Descripción:</label>
                                    <textarea name="description" id="form4" class="form-control" rows="6" placeholder="El estar en facebook provoca..." required>{{ old('description') }}</textarea>
                                    @if ($errors->has('description'))
                                        <p class="help-block">{{ $errors->first('description') }}</p>
                                    @endif
                                </div>
                            </form>
                        </div>
                        <div class="box-footer clearfix">
                            <button type="submit" form="appForm" class="pull-right btn btn-default" id="sendEmail">Send
                                <i class="fa fa-arrow-circle-right"></i></button>
                        </div>
                    </div>
                </section>

                <!--Second Row the numbers de applications-->
                <section class="col-lg-5 connectedSortable">
                    <div class="box box-info">
                        <div class="box-header">
                            <i class="fa fa-gear"></i>

                            <h3 class="box-title">Facebook</h3>
                            <!-- tools box -->
                            <div class="pull-right box-tools">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                    <i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" data-widget="remove" data-toggle="tooltip"
                                        title="Remove">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="small-box bg-yellow">
                                <div class="inner">
                                    <h3>150</h3>

                                    <p>Users registration</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                    </div>
                </section>

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

    <script src="{{ asset('bower_components/jquery-ui/jquery-ui.min.js') }}"></script>

    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>

    <!-- Bootstrap 3.3.7 -->
    <script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('bower_components/moment/min/moment.min.js') }}"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="{{ asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
    <!-- Slimscroll -->
    <script src="{{ asset('}bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>

    <script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>

    <script src="{{ asset('dist/js/demo.js') }}"></script>
@endsection