@extends('layouts.v_master')
@section('title', 'Dashboard RW')
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
        <h2>Halaman Berita</h2>
    </div>
    <!-- Small boxes (Stat box) -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-teal">
            <div class="inner">
                <h3>{{ $jml }}</h3>
                <p>Post Berita</p>
            </div>
            <div class="icon">
                <i class="far fa-newspaper"></i>
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
                    <h3 class="card-title font-weight-bold mr-2 mt-2">Detail Post Berita</h3>
                    <a href="#" class="btn btn-light bg-teal btn-sm add" style="float: right">
                        <i class="fas fa-plus"> Tambah</i>
                    </a>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive">
                    <table class="table table-hover table-sm table-bordered text-nowrap" id="datatableEdit">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Tanggal</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            <?php $no = 1; ?>
                            @foreach ($datas as $key => $data)
                                <tr>
                                    <td class="text-center align-middle">{{ $no }}</td>
                                    <td>{{ $data->judul }}</td>
                                    <td>{{ $data->created_at }}</td>
                                    <td class="text-center align-middle">
                                        {{-- <a href="#" class="btn btn-primary btn-sm edit" id-user="{{$data->id}}"><i class="fas fa-user-edit"></i></a> &nbsp; --}}
                                        <a href="#" class="btn btn-light bg-teal btn-sm" data-toggle="modal"
                                            data-target="#editModalBerita{{ $data->id }}"><i class="fas fa-edit"></i>
                                            Edit</a> &nbsp;
                                        <a href="#" class="btn btn-light bg-maroon btn-sm delete"
                                            judul="{{ $data->judul }}" id-berita="{{ $data->id }}"> <i
                                                class="fas fa-trash-alt"> Hapus</i></i></a>
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
    <!-- Add Modal -->
    <div class="modal fade" id="addModalBerita" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Berita</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="POST" id="addBerita" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        {{-- <form> --}}
                        <div class="form-group">
                            <label for="judul">Judul</label>
                            <input type="text" value="{{ old('judul') }}" class="form-control" id="judul"
                                name="judul" placeholder="Masukkan judul post">
                            @error('judul')
                                <div class="text-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="thumbnail" class="form-label">Thumbnail</label>
                            <img class="img-preview img-fluid mb-3 col-sm-5">
                            <input class="form-control" type="file" id="thumbnail" name="thumbnail"
                                onchange="previewImage()">
                            @error('thumbnail')
                                <div class="text-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="gambar1" class="form-label">Gambar Lainnya</label>
                            <img class="img-preview1 img-fluid mb-2 col-sm-4">
                            <input class="form-control" type="file" id="gambar1" name="gambar1"
                                onchange="previewImage1()">
                            @error('gambar1')
                                <div class="text-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="gambar2" class="form-label">Gambar Laiinya</label>
                            <img class="img-preview2 img-fluid mb-2 col-sm-4">
                            <input class="form-control" type="file" id="gambar2" name="gambar2"
                                onchange="previewImage2()">
                            @error('gambar2')
                                <div class="text-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="file" class="form-label">File Pendukung</label>
                            <input class="form-control" type="file" id="file" name="file">
                            @error('file')
                                <div class="text-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <label for="content">Konten</label>
                        {{-- <input id="content" type="hidden" name="content">
                <trix-editor input="content"></trix-editor> --}}
                        <textarea class="summernote" name="content" id="" cols="30" rows="10"></textarea>
                        {{-- <button type="submit" class="btn btn-primary">Submit</button> --}}
                        {{-- </form> --}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-light bg-teal">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End of Modal -->

    <!-- Start Modal -->
    <!-- Edit Modal -->
    @foreach ($datas as $data)
        <div class="modal fade" id="editModalBerita{{ $data->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Berita</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="/berita/edit/{{ $data->id }}" method="POST" id="editBerita"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            {{-- <form> --}}
                            <div class="form-group">
                                <label for="judulEdit">Judul</label>
                                <input type="text" value="{{ $data->judul }}" class="form-control" id="judulEdit"
                                    name="judulEdit" placeholder="Masukkan judul post">
                                @error('judulEdit')
                                    <div class="text-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="thumbnailEdit">Thumbnail</label>
                                <img class="img-preview-edit{{ $data->id }} img-fluid mb-3 col-sm-5 d-block"
                                    src="{{ asset('storage/' . $data->thumbnail) }}">
                                <input type="hidden" id="oldImage" name="oldImage" value="{{ $data->thumbnail }}">
                                <input class="form-control" type="file" id="thumbnailEdit{{ $data->id }}"
                                    name="thumbnailEdit" onchange="previewImageEdit({{ $data->id }})">
                                @error('thumbnailEdit')
                                    <div class="text-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="thumbnailEdit1">Gambar (Opsional)</label>
                                <img class="img-preview-edit1{{ $data->id }} img-fluid mb-3 col-sm-5 d-block"
                                    src="{{ asset('storage/' . $data->gambar1) }}">
                                <input type="hidden" id="oldImage1" name="oldImage1" value="{{ $data->gambar1 }}">
                                <input class="form-control" type="file" id="thumbnailEdit1{{ $data->id }}"
                                    name="thumbnailEdit1" onchange="previewImageEdit1({{ $data->id }})">
                                @error('thumbnailEdit1')
                                    <div class="text-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="thumbnailEdit2">Gambar (Opsional)</label>
                                <img class="img-preview-edit2{{ $data->id }} img-fluid mb-3 col-sm-5 d-block"
                                    src="{{ asset('storage/' . $data->gambar2) }}">
                                <input type="hidden" id="oldImage2" name="oldImage2" value="{{ $data->gambar2 }}">
                                <input class="form-control" type="file" id="thumbnailEdit2{{ $data->id }}"
                                    name="thumbnailEdit2" onchange="previewImageEdit2({{ $data->id }})">
                                @error('thumbnailEdit2')
                                    <div class="text-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="fileEdit">File Pendukung</label>
                                <input type="hidden" id="oldFile" name="oldFile" value="{{ $data->attachment }}">
                                <input class="form-control" type="file" name="fileEdit">
                                @error('fileEdit')
                                    <div class="text-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <label for="contentEdit">Konten</label>
                            {{-- <input id="contentEdit" type="hidden" name="contentEdit" value="{{$data->content}}">
                <trix-editor input="contentEdit"></trix-editor> --}}
                            <textarea class="form-control summernote" name="contentEdit">{!! $data->content !!}</textarea>
                            @error('contentEdit')
                                <div class="text-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                            {{-- <button type="submit" class="btn btn-primary">Submit</button> --}}
                            {{-- </form> --}}

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-light bg-teal">Simpan</button>
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
            $('#addModalBerita').modal('show')

            $tr = $(this).closest('tr');

            $('#addBerita').attr('action', '/berita/add');
        });
    </script>

    <script>
        $('.delete').click(function() {
            var id = $(this).attr('id-berita');
            var judul = $(this).attr('judul');
            swal({
                    title: "Anda Yakin?",
                    text: "Berita dengan judul " + judul + " ini akan dihapus",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        window.location = "berita/delete/" + id;
                        swal("Data berhasil dihapus", {
                            icon: "success",
                        });
                    } else {
                        swal("Berita tidak  dihapus");
                    }
                });
        });
    </script>

    <script>
        function previewImage() {

            const image = document.querySelector('#thumbnail');
            const imagePreview = document.querySelector('.img-preview');

            imagePreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imagePreview.src = oFREvent.target.result;
            }

        }

        function previewImage1() {

            const image1 = document.querySelector('#gambar1');
            const imagePreview = document.querySelector('.img-preview1');

            imagePreview.style.display = 'block';

            const oFReader1 = new FileReader();
            oFReader1.readAsDataURL(image1.files[0]);

            oFReader1.onload = function(oFREvent) {
                imagePreview.src = oFREvent.target.result;
            }

        }

        function previewImage2() {

            const image1 = document.querySelector('#gambar2');
            const imagePreview = document.querySelector('.img-preview2');

            imagePreview.style.display = 'block';

            const oFReader1 = new FileReader();
            oFReader1.readAsDataURL(image1.files[0]);

            oFReader1.onload = function(oFREvent) {
                imagePreview.src = oFREvent.target.result;
            }

        }

        function previewImageEdit(id) {

            const image = document.querySelector('#thumbnailEdit' + id);
            const imagePreview = document.querySelector('.img-preview-edit' + id);

            imagePreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imagePreview.src = oFREvent.target.result;
            }

        }

        function previewImageEdit1(id) {

            const image = document.querySelector('#thumbnailEdit1' + id);
            const imagePreview = document.querySelector('.img-preview-edit1' + id);

            imagePreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imagePreview.src = oFREvent.target.result;
            }

        }

        function previewImageEdit2(id) {

            const image = document.querySelector('#thumbnailEdit2' + id);
            const imagePreview = document.querySelector('.img-preview-edit2' + id);

            imagePreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

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
