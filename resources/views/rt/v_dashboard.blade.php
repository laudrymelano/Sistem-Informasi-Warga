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
        <h2 class="mb-2">Statistik Warga RT {{ Auth::user()->rt }}</h2>
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-header bg-teal">
                        <h3 class="card-title font-weight-bold mr-2 mt-0">Jenis Kelamin</h3>
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
                                style="min-height: 300px; height: 300px; max-height: 300px; max-width: 150%;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-header bg-teal">
                        <h3 class="card-title font-weight-bold mr-2 mt-0">Pekerjaan</h3>
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
                            <canvas id="barChartP"
                                style="min-height: 300px; height: 300px; max-height: 300px; max-width: 150%;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-header bg-teal">
                        <h3 class="card-title font-weight-bold mr-2 mt-0">Agama</h3>
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
                            <canvas id="barChartA"
                                style="min-height: 300px; height: 300px; max-height: 300px; max-width: 150%;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-header bg-teal">
                        <h3 class="card-title font-weight-bold mr-2 mt-0">Status Perkawinan</h3>
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
                            <canvas id="barChartSK"
                                style="min-height: 300px; height: 300px; max-height: 300px; max-width: 150%;"></canvas>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div><!-- /.container-fluid -->
    {{-- <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-teal">
                <div class="inner">
                    <h3>{{ $tKK }}</h3>
                    <p>Kartu Keluarga</p>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-teal">
                <div class="inner">
                    <h3>{{ $tWarga }}</h3>
                    <p>Warga</p>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
        </div>

    </div> --}}




@endsection

@section('scripts')
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
                label: "Jenis Kelamin",
                data: cData.data,
                backgroundColor: ['#008080', '#4682B4'],
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
            type: 'pie',
            data: pieData,
            options: pieOptions
        })
    </script>
    <script type="text/javascript">
        //-------------
        //- PIE CHART -
        //-------------
        // Get context with jQuery - using jQuery's .get() method.
        var cData = JSON.parse(`<?php echo $dataChartP['chart_dataP']; ?>`);
        var pieChartCanvas = $('#barChartP').get(0).getContext('2d')
        var pieData = {
            labels: cData.label,
            datasets: [{
                label: "Pekerjaan",
                data: cData.data,
                backgroundColor: ['#008080', '#4682B4', '#004962', '#009AB9', '#00FFFF', '#6DC5FB'],
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
            type: 'pie',
            data: pieData,
            options: pieOptions
        })
    </script>
    <script type="text/javascript">
        //-------------
        //- PIE CHART -
        //-------------
        // Get context with jQuery - using jQuery's .get() method.
        var cData = JSON.parse(`<?php echo $dataChartA['chart_dataA']; ?>`);
        var pieChartCanvas = $('#barChartA').get(0).getContext('2d')
        var pieData = {
            labels: cData.label,
            datasets: [{
                label: "Agama",
                data: cData.data,
                backgroundColor: ['#008080', '#4682B4', '#004962', '#009AB9', '#00FFFF', '#6DC5FB'],
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
            type: 'pie',
            data: pieData,
            options: pieOptions
        })
    </script>
    <script type="text/javascript">
        //-------------
        //- PIE CHART -
        //-------------
        // Get context with jQuery - using jQuery's .get() method.
        var cData = JSON.parse(`<?php echo $dataChartSK['chart_dataSK']; ?>`);
        var pieChartCanvas = $('#barChartSK').get(0).getContext('2d')
        var pieData = {
            labels: cData.label,
            datasets: [{
                label: "Status Perkawinan",
                data: cData.data,
                backgroundColor: ['#008080', '#4682B4', '#004962', '#009AB9', '#00FFFF'],
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
            type: 'pie',
            data: pieData,
            options: pieOptions
        })
    </script>
@endsection

{{-- @section('scripts')
    <script>
        $('select#filter, select#subFilter').change(function() {
            if ($(this).val()) {
                if ($(this).val() == 'jenis_kelamin') {
                    $('select#subFilter').fadeIn();
                    $('select#subFilter').html('');
                    $('select#subFilter').append(new Option('LAKI-LAKI', 'LAKI-LAKI'));
                    $('select#subFilter').append(new Option('PEREMPUAN', 'PEREMPUAN'));
                } else if ($(this).val() == 'pekerjaan') {
                    $('select#subFilter').fadeIn();
                    $('select#subFilter').html('');
                    $('select#subFilter').append(new Option('PELAJAR/MAHASISWA', 'PELAJAR/MAHASISWA'));
                    $('select#subFilter').append(new Option('KARYAWAN SWASTA', 'KARYAWAN SWASTA'));
                    $('select#subFilter').append(new Option('WIRASWASTA', 'WIRASWASTA'));
                    $('select#subFilter').append(new Option('BELUM/TIDAK BEKERJA', 'BELUM/TIDAK BEKERJA'));
                    $('select#subFilter').append(new Option('BURUH HARIAN LEPAS', 'BURUH HARIAN LEPAS'));
                } else {
                    $('select#subFilter').fadeOut();
                }
            }
            $("#datatableExport").DataTable().ajax.reload();
        });
        $("#datatableExport").DataTable({
            responsive: true,
            destroy: true,
            dom: 'lBfrtip',
            lengthMenu: [
                [25, 50, 100, -1],
                [25, 50, 100, "Semua"]
            ],
            autoWidth: true,
            buttons: [
                "excel",
                {
                    extend: "pdf",
                    exportOptions: {
                        columns: ':visible'
                    },
                    orientation: 'landscape',
                    pageSize: 'LEGAL'
                },
                {
                    extend: "print",
                    exportOptions: {
                        columns: ':visible'
                    },
                    customize: function(win) {
                        let last = null;
                        let current = null;
                        let bod = [];
                        let css = '@page { size: Legal landscape; }',
                            head = win.document.head || win.document.getElementsByTagName(
                                'head')[0],
                            style = win.document.createElement('style');

                        style.type = 'text/css';
                        style.media = 'print';

                        if (style.styleSheet) {
                            style.styleSheet.cssText = css;
                        } else {
                            style.appendChild(win.document.createTextNode(css));
                        }
                        head.appendChild(style);
                    }
                },
                'colvis'
            ],
            processing: true,
            deferRender: true,
            serverSide: true,
            ajax: {
                url: "{{ url('rt/getDataDashboard') }}",
                type: "POST",
                data: function(d) {
                    d._token = '{{ csrf_token() }}';
                    d.filter = $('select#filter').val();
                    d.subfilter = $('select#subFilter').val();
                }
            },
            columns: [{
                    data: "nama"
                },
                {
                    data: "ttl"
                },
                {
                    data: "jenis_kelamin"
                },
                {
                    data: "alamat"
                },
                {
                    data: "rt"
                },
                {
                    data: "rw"
                },
                {
                    data: "kelurahan"
                },
                {
                    data: "kecamatan"
                },
                {
                    data: "agama"
                },
                {
                    data: "status_perkawinan"
                },
                {
                    data: "pekerjaan"
                },
            ],
        });
    </script>

@endsection --}}

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
