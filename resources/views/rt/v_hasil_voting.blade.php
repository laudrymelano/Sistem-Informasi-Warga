@extends('layouts.v_master')
@section('title', 'Dashboard RT')
@push('custom-css')
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/jqvmap/jqvmap.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote-bs4.min.css') }}">
@endpush
@section('content')
    <div class="container-fluid">
        <h2>E-Voting</h2>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title font-weight-bold mr-2 mt-2" style="color: teal">Hasil Rekapitulasi Suara </h3>
                        {{-- <select class="form-control mr-2 mb-lg-0 mb-2" style="width: 180px">
                            <option selected>-- Seluruh Periode --</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select> --}}
                        {{-- <a href="#" class="btn btn-light bg-teal btn-sm add" style="float: right">
                            <i class="fas fa-user-plus"></i>
                        </a> --}}
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive">
                        <table class="table table-hover table-sm text-nowrap" id="datatable">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center align-middle">No. Urut</th>
                                    <th>Nama Calon</th>
                                    <th class="text-center align-middle">Jumlah Suara</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @foreach ($datas as $key => $data)
                                    <tr>
                                        <td class="text-center align-middle">{{ $data->no_urut }}</td>
                                        <td>{{ $data->nama }}</td>
                                        <td class="text-center align-middle">{{ $data->jumlahPemilih }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <hr>
                    <h3 class="card-title font-weight-bold ml-4 mt-2" style="color: teal">Hasil Rekapitulasi Suara
                    </h3>
                    <hr>
                    @if (!blank($datas))
                        <div class="container-fluid ml-5 mb-2 mt-2">
                            <div class="row">
                                <div class="col-6">
                                    <p><b>Total Pemilih</b></p>
                                </div>
                                <div class="col-6 text-center">
                                    <p>{{ $totalPemilih }}</p>
                                </div>
                                <div class="col-6">
                                    <p><b>Total Suara Masuk</b></p>
                                </div>
                                <div class="col-6 text-center ">
                                    <p>{{ $totalSuara }}</p>
                                </div>

                                <div class="col-6">
                                    <p><b>Total Golput</b></p>
                                </div>
                                <div class="col-6 text-center">
                                    {{ $totalGolput }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <!-- /.card -->

                <div class="card">
                    <div class="card-header bg-teal">
                        <h3 class="card-title font-weight-bold mr-2 mt-2">Perolehan Suara</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool bg-light" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            {{-- <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button> --}}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="barChart"
                                style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                </div>
            </div>


            <!-- /.row (main row) -->
        </div>
    </div><!-- /.container-fluid -->
@endsection

@section('scripts')
    @if (!blank($datas))
        <script type="text/javascript">
            //-------------
            //- PIE CHART -
            //-------------
            // Get context with jQuery - using jQuery's .get() method.
            var cData = JSON.parse(`<?php echo $dataChart['chart_data']; ?>`);
            var pieChartCanvas = $('#barChart').get(0).getContext('2d')
            var pieData = {
                labels: cData.label,
                datasets: [{
                    label: "Perolehan Suara",
                    data: cData.data,
                    backgroundColor: ['#4682B4', '#008080', '#004962'],
                }]
            }
            var pieOptions = {
                maintainAspectRatio: false,
                responsive: true,
                datasetFill: false,
            }
            //Create pie or douhnut chart
            // You can switch between pie and douhnut using the method below.
            new Chart(pieChartCanvas, {
                type: 'bar',
                data: pieData,
                options: pieOptions
            })
        </script>
    @endif

@endsection

@push('custom-js')
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('') }}assets/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('assets/plugins/chart.js/Chart.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ asset('assets/plugins/sparklines/sparkline.js') }}"></script>
    <!-- JQVMap -->
    <script src="{{ asset('assets/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('assets/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ asset('assets/dist/js/pages/dashboard.js') }}"></script>
@endpush
