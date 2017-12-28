@extends('layouts.fc-admin')

@section('title-page', 'Applicaciones')

@section('styles')
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('bower_components/Ionicons/css/ionicons.min.css') }}">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{ asset('plugins/iCheck/all.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('dist/css/skins/_all-skins.min.css') }}">
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
        <section class="content container-fluid">
            <div class="row">
                <!--First Row the users-registration-->
                <section class="col-lg-7 connectedSortable ui-sortable">
                    <div class="box box-{{ isset($message) ? 'success' : 'info'}}">
                        <div class="box-header">
                            <i class="fa fa-gear"></i>

                            <h3 class="box-title">{{ isset($findApp) ? 'Actualizar: '. $findApp->name_application : 'Nueva aplicacion' }}</h3>
                            <!-- tools box -->
                            <div class="pull-right box-tools">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                    <i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-{{ isset($message) ? 'success' : 'info'}} btn-sm" data-widget="remove" data-toggle="tooltip"
                                        title="Remove">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body">
                            <form id="appForm" action="{{ route('application.submit') }}" method="POST">
                                {{ csrf_field() }}

                                <input type="hidden" name="id" value="{{ isset($findApp) ? $findApp->id : '' }}">

                                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                    <label for="form1">Nombre de la aplicación: </label>
                                    <input type="text" name="name" id="form1" class="form-control" placeholder="Ejemplo: Facebook" value="{{ isset($findApp) ? $findApp->name_application : old('name') }}" required>

                                    @if ($errors->has('name'))
                                        <p class="help-block">{{ $errors->first('name') }}</p>
                                    @endif
                                </div>
                                <div class="form-group {{ $errors->has('relevance') ? 'has-error' : '' }}">
                                    <label for="form2">Relevancia: </label>
                                    <input type="text" name="relevance" id="form2" class="form-control" placeholder="(10:Alta)...(1:Baja)" value="{{ isset($findApp) ? $findApp->relevance : old('relevance') }}" required>
                                    @if ($errors->has('relevance'))
                                        <p class="help-block">{{ $errors->first('relevance') }}</p>
                                    @endif
                                </div>
                                <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                                    <label for="form3">Ruta de la imagen: </label>
                                    <input type="text" name="image" id="form3" class="form-control" placeholder="http://lorempixel.com/400/200/..." value="{{ isset($findApp) ? $findApp->image : old('image') }}" required>

                                    @if ($errors->has('image'))
                                        <p class="help-block">{{ $errors->first('image') }}</p>
                                    @endif
                                </div>
                                <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                                    <label for="form4">Descripción:</label>
                                    <textarea name="description" id="form4" class="form-control" rows="6" placeholder="El estar en facebook provoca..." required>{{ isset($findApp) ? $findApp->description : old('description') }}</textarea>

                                    @if ($errors->has('description'))
                                        <p class="help-block">{{ $errors->first('description') }}</p>
                                    @endif
                                </div>
                            </form>
                        </div>
                        <div class="box-footer clearfix">
                            <button type="submit" form="appForm" class="pull-right btn btn-default" id="sendEmail">{{ isset($findApp) ? 'Actualizar' : 'Añadir'}}
                                <i class="fa fa-arrow-circle-right"></i></button>
                        </div>
                    </div>
                </section>

                <!--Second Row the numbers de applications-->
                <section class="col-lg-5 connectedSortable">
                    <div class="box box-info">
                        <div class="box-header">
                            <i class="ion ion-clipboard"></i>

                            <h3 class="box-title">Lista de aplicaciones</h3>
                            <!-- tools box -->
                            <div class="pull-right box-tools">
                                {{ $applications->links('vendor.pagination.default-sm') }}
                            </div>
                        </div>
                        <div class="box-body">
                            <ul class="todo-list">
                                @foreach($applications as $application)
                                    <li>
                                        <span class="handle">
                                            <i class="fa fa-ellipsis-v"></i>
                                            <i class="fa fa-ellipsis-v"></i>
                                        </span>
                                        <label for="">
                                            <input type="checkbox" class="flat-red">
                                        </label>
                                        <span class="text">{{ $application->name_application }}</span>
                                        <div class="tools">
                                            <a href="{{ route('application.edit', $application->id) }}"><i class="fa fa-edit"></i></a>
                                            <!--data-toggle="modal" data-target="#modal-danger" data-value="-->
                                            <a href="{{ route('application.delete', $application->id) }}" class="text-red" ><i class="fa fa-trash-o"></i></a>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="box-footer clearfix no-border">
                            <form action="{{ route('application.index') }}">
                                <button type="submit" class="btn btn-default pull-right"><i class="fa fa-plus"></i> Añadir nueva app</button>
                            </form>
                        </div>
                    </div>
                </section>
            </div>
            <!--Modal-->
            <div class="modal modal-danger fade" id="modal-danger">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Esta seguro</h4>
                        </div>
                        <div class="modal-body">
                            <p>Los datos no se podran recuperar&hellip;</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                            <form action="" method="POST">
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-outline">Continuar</button>
                            </form>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
        </section>
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
    <!-- FastClick -->
    <script src="{{ asset('bower_components/fastclick/lib/fastclick.js') }}"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="{{ asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
    <!-- Slimscroll -->
    <script src="{{ asset('bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
    <!-- iCheck 1.0.1 -->
    <script src="{{ asset('plugins/iCheck/icheck.min.js') }}"></script>

    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>

    <script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>

    <script src="{{ asset('dist/js/demo.js') }}"></script>

    <script>
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass   : 'iradio_flat-green'
        });
    </script>
@endsection