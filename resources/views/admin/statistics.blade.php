@extends('layouts.fc-admin')

@section('title-page', 'Statistics')

@section('styles')
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('bower_components/Ionicons/css/ionicons.min.css') }}">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/autofill/2.2.2/css/autoFill.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.bootstrap.min.css">
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
        <section class="content container-fluid">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Usuarios</h3>
                        </div>

                        <div class="box-body">
                            <table id="tableStatistics" class="table table-bordered table-hover" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Username</th>
                                        <th>DNI</th>
                                        <th>Correo</th>
                                        <th>Fecha de nac</th>
                                        <th>Cond. Act</th>
                                        <th>Sex</th>
                                        <th>Edad</th>
                                        <th>Tiempo estimado</th>
                                        @for($i = 1; $i <= $days; $i++ )
                                            <th>Tiempo General dia {{ $i }}</th>
                                            <th>Nº Apps dia {{ $i }}</th>
                                            <th>App top dia {{ $i }}</th>
                                        @endfor
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($statistics as $statistic)
                                    <tr>
                                        <td>{{ $statistic['id'] }}</td>
                                        <td>{{ $statistic['name'] }}</td>
                                        <td>{{ $statistic['dni'] }}</td>
                                        <td>{{ $statistic['email'] }}</td>
                                        <td>{{ date('d/m/Y', strtotime($statistic['birth_date'])) }}</td>
                                        <td>{{ $statistic['state'] }}</td>
                                        <td>{{ $statistic['sex'] }}</td>
                                        <td>{{ getUserAge($statistic['birth_date']) }}</td>
                                        <td>{{ $statistic['use_time'] }}</td>
                                        @for($i = 0; $i < $days; $i++ )
                                            <td>{{ (isset($statistic['historics'][$i])) ? $statistic['historics'][$i]['time_use'] : '' }}</td>
                                            <td>{{ (isset($statistic['historics'][$i])) ? $statistic['historics'][$i]['quantity_app_use'] : '' }}</td>
                                            <td>{{ (isset($statistic['historics'][$i])) ? $statistic['historics'][$i]['app_top'] : '' }}</td>
                                        @endfor
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!--Second Row the numbers de applications-->
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
    <!-- Bootstrap 3.3.7 -->
    <script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.5/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.35/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.35/vfs_fonts.js"></script>

    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>

    <script src="https://cdn.datatables.net/autofill/2.2.2/js/dataTables.autoFill.min.js"></script>
    <script src="https://cdn.datatables.net/autofill/2.2.2/js/autoFill.bootstrap.min.js"></script>

    <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.bootstrap.min.js"></script>

    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>

    <script src="{{ asset('bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>

    <script src="{{ asset('bower_components/fastclick/lib/fastclick.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#tableStatistics').DataTable({
                dom : 'lrtip<"bottom"B><"clear">',
                'scrollX': true,
                'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>
@endsection

