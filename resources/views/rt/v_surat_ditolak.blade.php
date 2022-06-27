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
        <h2>Surat</h2>

        <!-- Small boxes (Stat box) -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-teal">
                <div class="inner">
                    <h3>{{ $jml }}</h3>
                    <p>Surat Ditolak</p>
                </div>
                <div class="icon">
                    <i class="far fa-envelope"></i>
                </div>
                {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
            </div>
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <!-- /.row -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title font-weight-bold mr-2 mt-2" style="color: teal">Detail Surat Ditolak</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive">
                        <table class="table table-hover table-sm table-bordered text-nowrap" id="datatable-export">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No. Surat</th>
                                    <th>Warga</th>
                                    <th>Keperluan</th>
                                    <th>KTP</th>
                                    <th>KK</th>
                                    <th>Keterangan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            </thead>
                            <tbody class="list">
                                <?php $no = 1; ?>
                                @foreach ($datas as $key => $data)
                                    <tr>
                                        <td class="text-center align-middle">{{ $no }}</td>
                                        <td>{{ $data->no_surat }}</td>
                                        <td>{{ $data->nama }}</td>
                                        <td>{{ $data->keperluan }}</td>
                                        <td class="text-center align-middle"> <a href="#"
                                                class="btn btn-light bg-olive btn-sm" data-toggle="modal"
                                                data-target="#showModalKTP{{ $data->id }}"><i class="fas fa-eye"> |
                                                    KTP</i></a> &nbsp;</td>
                                        <td class="text-center align-middle"> <a href="#"
                                                class="btn btn-light bg-olive btn-sm" data-toggle="modal"
                                                data-target="#showModalKK{{ $data->id }}"><i class="fas fa-eye"> |
                                                    KK</i></a> &nbsp;</td>
                                        <td>{{ $data->keterangan }}</td>
                                        <td class="text-center align-middle">
                                            <a href="#" class="btn btn-light bg-teal btn-sm " data-toggle="modal"
                                                data-target="#showModalNote{{ $data->id }}"><i
                                                    class="fas fa-comment-alt"> | Catatan</i></a> &nbsp;
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

        <!-- Start Modal -->
        <!-- Edit Modal -->
        @foreach ($datas as $data)
            <div class="modal fade" id="showModalKTP{{ $data->id }}" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">File KTP {{ $data->nama }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="#" method="POST" id="showKTP" enctype="multipart/form-data">
                            <div class="modal-body">
                                {{-- <form> --}}
                                <div class="form-group">
                                    <label for="showKTP">Foto KTP (Kartu Tanda Penduduk)</label>
                                    <img class="img-preview-KTP{{ $data->id }} img-fluid mb-3 col-md-9 rounded mx-auto d-block"
                                        src="{{ asset('storage/' . $data->fileKTP) }}">
                                    {{-- <input type="hidden" id="oldImage" name="oldImage" value="{{$data->thumbnail}}">
                    <input class="form-control" type="file" id="thumbnailEdit{{$data->id}}" name="thumbnailEdit" onchange="previewImageEdit({{$data->id}})"> --}}
                                    @error('showKTP')
                                        <div class="text-danger mt-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                {{-- <button type="submit" class="btn btn-primary">Submit</button> --}}
                                {{-- </form> --}}

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                {{-- <button type="submit" class="btn btn-primary">Simpan</button> --}}
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End of Modal -->
        @endforeach

        @foreach ($datas as $data)
            <div class="modal fade" id="showModalKK{{ $data->id }}" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">File KK {{ $data->nama }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="#" method="POST" id="showKK" enctype="multipart/form-data">
                            <div class="modal-body">
                                {{-- <form> --}}
                                <div class="form-group">
                                    <label for="showKK">Foto KK (Kartu Keluarga)</label>
                                    <img class="img-preview-kk{{ $data->id }} img-fluid mb-3 col-md-9 rounded mx-auto d-block"
                                        src="{{ asset('storage/' . $data->fileKK) }}">
                                    {{-- <input type="hidden" id="oldImage" name="oldImage" value="{{$data->thumbnail}}">
                    <input class="form-control" type="file" id="thumbnailEdit{{$data->id}}" name="thumbnailEdit" onchange="previewImageEdit({{$data->id}})"> --}}
                                    @error('showKK')
                                        <div class="text-danger mt-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                {{-- <button type="submit" class="btn btn-primary">Submit</button> --}}
                                {{-- </form> --}}

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                {{-- <button type="submit" class="btn btn-primary">Simpan</button> --}}
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach

        @foreach ($datas as $data)
            <!-- Start Modal -->
            <!-- Note Modal -->
            <div class="modal fade" id="showModalNote{{ $data->id }}" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Catatan untuk {{ $data->nama }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="/rt/surat/note/{{ $data->id }}" method="POST" id="addNote"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                {{-- <form> --}}
                                <div class="form-group">
                                    <label for="note">Catatan Perbaikan</label>
                                    <input type="text" value="{{ $data->catatan }}" class="form-control"
                                        name="note" placeholder="Tuliskan catatan perbaikan">
                                    @error('note')
                                        <div class="text-danger mt-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                {{-- <button type="submit" class="btn btn-primary">Submit</button> --}}
                                {{-- </form> --}}

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
        <!-- End of Modal -->


    @endsection

    @section('scripts')
        <script>
            function previewImageShowKTP(id) {

                // const image = document.querySelector('#thumbnailEdit'+id);
                const imagePreview = document.querySelector('.img-preview-ktp' + id);

                imagePreview.style.display = 'block';

                const oFReader = new FileReader();
                oFReader.readAsDataURL(image.files[id]);

                oFReader.onload = function(oFREvent) {
                    imagePreview.src = oFREvent.target.result;
                }
            }

            function previewImageShowKK(id) {

                // const image = document.querySelector('#thumbnailEdit'+id);
                const imagePreview = document.querySelector('.img-preview-kk' + id);

                imagePreview.style.display = 'block';

                const oFReader = new FileReader();
                oFReader.readAsDataURL(image.files[id]);

                oFReader.onload = function(oFREvent) {
                    imagePreview.src = oFREvent.target.result;
                }
            }
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
