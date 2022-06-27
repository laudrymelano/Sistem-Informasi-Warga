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
        {{-- <h1>Halaman RT</h1> --}}
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-teal">
                    <div class="inner">
                        <h3>{{ $rt }}</h3>
                        <p>Rukun Tetangga</p>
                        <div class="icon">
                            <i class="fas fa-home"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold mr-2 mt-2">Detail Akun RT</h3>
                    <a href="#" class="btn btn-light bg-teal btn-sm add" style="float: right">
                        <i class="fas fa-plus"> Tambah</i>
                    </a>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-hov   er table-sm table-striped table-bordered" id="datatable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Username</th>
                                <th>Rukun Tetangga</th>
                                <th class="text-center align-middle">Action</th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            <?php $no = 1; ?>
                            @foreach ($datas as $key => $data)
                                <tr>
                                    <td class="text-center align-middle">{{ $no }}</td>
                                    <td>{{ $data->name }}</td>
                                    <td>{{ $data->rt }}</td>
                                    <td class="text-center align-middle">
                                        <a href="#" class="btn btn-light bg-teal btn-sm" data-toggle="modal"
                                            data-target="#editModalAkun{{ $data->id }}"><i class="fas fa-edit">
                                                Edit</i> </a> &nbsp;
                                        <a href="#" class="btn btn-light bg-maroon btn-sm delete"
                                            nama="{{ $data->name }}" id-rt="{{ $data->id }}"> <i
                                                class="fas fa-trash-alt">
                                                Hapus</i></a>
                                    </td>
                                </tr>
                                <?php $no++; ?>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addModalAkun" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Akun</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="POST" id="addAkun" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        {{-- <form> --}}
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" value="{{ old('name') }}" class="form-control" id="name"
                                name="name" placeholder="Masukkan Username">
                            @error('name')
                                <div class="text-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="rt">Rukun Tetangga</label>
                            <input type="text" value="{{ old('rt') }}" class="form-control" id="rt"
                                name="rt" placeholder="Masukkan Rukun Tetangga">
                            @error('rt')
                                <div class="text-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="text" value="{{ old('password') }}" class="form-control" id="password"
                                name="password" placeholder="Masukkan Password">
                            @error('password')
                                <div class="text-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End of Modal -->

    @foreach ($datas as $data)
        <!-- Edit Modal -->
        <div class="modal fade" id="editModalAkun{{ $data->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Akun</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="/rw/akun/edit/{{ $data->id }}" method="POST" id="editAkun"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            {{-- <form> --}}
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" value="{{ $data->name }}" class="form-control" id="name"
                                    name="name" placeholder="Masukkan Username">
                                @error('name')
                                    <div class="text-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="rt">Rukun Tetangga</label>
                                <input type="text" value="{{ $data->rt }}" class="form-control" id="rt"
                                    name="rt" placeholder="Masukkan Rukun Tetangga">
                                @error('rt')
                                    <div class="text-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="text" class="form-control" id="password" name="password"
                                    placeholder="Masukkan Password Baru">
                                @error('password')
                                    <div class="text-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End of Modal -->
    @endforeach

@endsection

@section('scripts')
    <script>
        $('.add').click(function() {
            $('#addModalAkun').modal('show')

            $tr = $(this).closest('tr');

            $('#addAkun').attr('action', '/rw/add/akun');
        });
    </script>

    <script>
        $('.delete').click(function() {
            var id = $(this).attr('id-rt');
            var uname = $(this).attr('nama');
            swal({
                    title: "Anda Yakin?",
                    text: "Akun RT dengan username " + uname + " ini akan dihapus",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        window.location = "/akun/delete/" + id;
                        swal("Data berhasil dihapus", {
                            icon: "success",
                        });
                    } else {
                        swal("Akun tidak  dihapus");
                    }
                });
        });
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
