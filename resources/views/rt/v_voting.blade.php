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
        <!-- /.container-fluid -->
        <!-- /.row -->
        <!-- Main row -->
        <!-- /.row -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title font-weight-bold mr-2 mt-2" style="color: teal">Detail E-Voting</h3>
                        <a href="#" class="btn btn-light bg-teal btn-sm add" style="float: right">
                            <i class="fas fa-plus"> Tambah</i>
                        </a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive">
                        <table class="table table-hover table-sm table-bordered text-nowrap" id="datatable">
                            <thead>
                                <tr>
                                    <th class="text-center align-middle">No</th>
                                    <th>Judul</th>
                                    <th>Periode</th>
                                    <th class="text-center align-middle">Action</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                <?php $no = 1; ?>
                                @foreach ($datas as $key => $data)
                                    <tr>
                                        <td class="text-center align-middle">{{ $no }}</td>
                                        <td>{{ $data->judul }}</td>
                                        <td>{{ $data->periode }}</td>
                                        <td class="text-center align-middle">
                                            <a href="#" class="btn btn-light bg-teal btn-sm" data-toggle="modal"
                                                data-target="#editModalVoting{{ $data->id }}"><i class="fas fa-edit">
                                                    Edit</i></a> &nbsp;
                                            <a href="#" class="btn btn-light bg-maroon btn-sm delete"
                                                judul="{{ $data->judul }}" periode="{{ $data->periode }}"
                                                id-voting="{{ $data->id }}"> <i class="fas fa-trash-alt">
                                                    Hapus</i></a>&nbsp;
                                            @if ($data->status == '0')
                                                &nbsp;<a href="#" class="btn btn-primary btn-sm open"
                                                    judul="{{ $data->judul }}" periode="{{ $data->periode }}"
                                                    id-voting="{{ $data->id }}"> <i class="fas fa-eye"> Buka</i></a>
                                            @endif
                                            @if ($data->status == '1')
                                                &nbsp;<a href="#" class="btn btn-warning btn-sm tutup"
                                                    judul="{{ $data->judul }}" periode="{{ $data->periode }}"
                                                    id-voting="{{ $data->id }}"> <i class="fas fa-eye-slash">
                                                        Tutup</i></a>
                                            @endif
                                            @if ($data->status == '2')
                                                &nbsp;<a href="#" target="_blank" class="btn btn-success btn-sm cetak"
                                                    id-voting="{{ $data->id }}"> <i class="fas fa-print"> Cetak</i></a>
                                            @endif
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

            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </div>

    <!-- Start Modal -->
    <!-- Add Modal -->
    <div class="modal fade" id="addModalVoting" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah E-Voting</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="POST" id="addVoting" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        {{-- <form> --}}
                        <div class="form-group">
                            <label for="judul">Judul</label>
                            <input type="text" value="{{ old('judul') }}" class="form-control" id="judul"
                                name="judul" placeholder="Masukkan Judul Voting">
                            @error('judul')
                                <div class="text-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="periode" class="form-label">Periode <i>(Contoh : 2019-2022)</i></label>
                            <input type="text" value="{{ old('periode') }}" class="form-control" id="periode"
                                name="periode" placeholder="Masukkan Periode E-Voting">
                            @error('periode')
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

    <!-- Start Modal -->
    <!-- Edit Modal -->
    @foreach ($datas as $data)
        <div class="modal fade" id="editModalVoting{{ $data->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Berita</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="/voting/edit/{{ $data->id }}" method="POST" id="editVoting"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            {{-- <form> --}}
                            <div class="form-group">
                                <label for="judulEdit">Judul</label>
                                <input type="text" value="{{ $data->judul }}" class="form-control" id="judulEdit"
                                    name="judulEdit" placeholder="Masukkan judul E-Voting">
                                @error('judulEdit')
                                    <div class="text-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="periodeEdit">Periode</label>
                                <input type="text" value="{{ $data->periode }}" class="form-control"
                                    id="periodeEdit" name="periodeEdit" placeholder="Masukkan periode e-voting">
                                @error('judulEdit')
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
            $('#addModalVoting').modal('show')

            $tr = $(this).closest('tr');

            $('#addVoting').attr('action', '/rt/voting/add');
        });
    </script>

    <script>
        $('.cetak').click(function() {
            var id = $(this).attr('id-voting');
            if (id) {
                window.location = "/rt/print/voting/" + id;
            }
        });
    </script>

    <script>
        $('.open').click(function() {
            var id = $(this).attr('id-voting');
            var judul = $(this).attr('judul');
            var periode = $(this).attr('periode');
            swal({
                    title: "Anda Yakin?",
                    text: "E-Voting dengan judul " + judul + " periode " + periode + " ini akan dimulai",
                    icon: "warning",
                    buttons: [true, "Ya, Saya Yakin"],
                    dangerMode: false,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        window.location = "/voting/open/" + id;
                        swal("Evoting telah dibuka", {
                            icon: "success",
                        });
                    }
                    // else {
                    //     swal("Status surat belum di update");
                    // }
                });
        });
    </script>
    <script>
        $('.tutup').click(function() {
            var id = $(this).attr('id-voting');
            var judul = $(this).attr('judul');
            var periode = $(this).attr('periode');
            swal({
                    title: "Anda Yakin?",
                    text: "E-Voting dengan judul " + judul + " periode " + periode + " ini akan tutup",
                    icon: "warning",
                    buttons: [true, "Ya, Saya Yakin"],
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        window.location = "/voting/close/" + id;
                        swal("Evoting telah ditutup", {
                            icon: "success",
                        });
                    }
                    // else {
                    //     swal("Status surat belum di update");
                    // }
                });
        });
    </script>

    <script>
        $('.delete').click(function() {
            var id = $(this).attr('id-voting');
            var judul = $(this).attr('judul');
            var periode = $(this).attr('periode');
            swal({
                    title: "Anda Yakin?",
                    text: "E-Voting dengan judul " + judul + " periode " + periode + " ini akan dihapus",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        window.location = "/voting/delete/" + id;
                        swal("Data berhasil dihapus", {
                            icon: "success",
                        });
                    }
                    // else {
                    //     swal("E-voting tidak  dihapus");
                    // }
                });
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
