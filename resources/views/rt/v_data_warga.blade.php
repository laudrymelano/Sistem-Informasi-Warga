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
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-teal">
                    <div class="inner">
                        <h3>{{ $tKK }}</h3>
                        <p>Total KK</p>
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
                        <p>Total Warga</p>
                        <div class="icon">
                            <i class="fas fa-user"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <h1>Halaman RT</h1> --}}
    </div><!-- /.container-fluid -->


    <div class="row">
        <div class="col-12">
            <div class="card">
                {{-- <form action="" method="GET"> --}}
                <div class="card-header d-lg-flex">
                    <h3 class="card-title font-weight-bold mr-2 mt-2">Filter : </h3>
                    <select name="opt" id="filter" class="form-control mr-2 mb-lg-0 mb-2" style="width: 200px">
                        <option value="semua">Semua</option>
                        <option value="jenis_kelamin">Jenis Kelamin</option>
                        <option value="pekerjaan">Pekerjaan</option>
                        <option value="agama">Agama</option>
                        <option value="status_kawin">Status Kawin</option>
                    </select>
                    <select name="opt" id="subFilter" class="form-control mr-2 mb-lg-0 mb-2"
                        style="width: 200px; display: none;">
                    </select>
                    {{-- <button type="button" id="show" class="btn btn-warning mr-2 mb-lg-0 mb-2">Tampilkan</button> --}}
                </div>
                {{-- </form> --}}
                <div class="card-body table-responsive">
                    <table class="table table-hov   er table-sm table-striped table-bordered" id="datatableExport">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>TTL</th>
                                <th>Jenis Kelamin</th>
                                <th>Alamat</th>
                                <th>RT</th>
                                <th>RW</th>
                                <th>Kelurahan</th>
                                <th>Kecamatan</th>
                                <th>Agama</th>
                                <th>Status Perkawinan</th>
                                <th>Pekerjaan</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>

@endsection

@section('scripts')
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
                } else if ($(this).val() == 'agama') {
                    $('select#subFilter').fadeIn();
                    $('select#subFilter').html('');
                    $('select#subFilter').append(new Option('ISLAM', 'ISLAM'));
                    $('select#subFilter').append(new Option('KRISTEN', 'KRISTEN'));
                    $('select#subFilter').append(new Option('KATOLIK', 'KATOLIK'));
                    $('select#subFilter').append(new Option('HINDU', 'HINDU'));
                    $('select#subFilter').append(new Option('BUDDHA', 'BUDDHA'));
                    $('select#subFilter').append(new Option('KHONGHUCU', 'KHONGHUCU'));
                } else if ($(this).val() == 'status_kawin') {
                    $('select#subFilter').fadeIn();
                    $('select#subFilter').html('');
                    $('select#subFilter').append(new Option('BELUM KAWIN', 'BELUM KAWIN'));
                    $('select#subFilter').append(new Option('KAWIN', 'KAWIN'));
                    $('select#subFilter').append(new Option('CERAI HIDUP', 'CERAI HIDUP'));
                    $('select#subFilter').append(new Option('CERAI', 'CERAI MATI'));
                    $('select#subFilter').append(new Option('BUDDHA', 'BUDDHA'));
                    $('select#subFilter').append(new Option('KHONGHUCU', 'KHONGHUCU'));
                } else if ($(this).val() == 'semua') {
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
