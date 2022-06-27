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
    </div><!-- /.container-fluid -->
    <div class="container-fluid">
        <div class="card shadow bg-body rounded ">
            <div class="card-body ">
                <div class="row">
                    <div class="col-6">
                        <h3 class="card-title font-weight-bold mr-2 mt-2" style="color: teal">Data Calon Ketua RT </h3>
                        {{-- <select required name="periodeV" class="form-control mr-2 mb-lg-0 mb-2" style="width: 180px">
                            <option selected>-- Pilih Periode --</option>
                            @foreach ($voting as $items)
                                <option value="{{ $items->id }}">{{ $items->periode }}</option>
                            @endforeach
                        </select> --}}
                    </div>
                    <div class="col-6">
                        <a href="#" class="btn btn-light bg-teal btn-sm mr-2 mb-lg-0 mb-2 " style="float: right">
                            <i class="fas fa-user-plus add"> Tambah</i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" id="data_calon">
            @foreach ($datas as $data)
                <div class="col-lg-6 col-md-6 d-flex align-items-stretch mt-4">
                    <div class="card shadow bg-body rounded ">
                        <div class="row">
                            <div class="col-6">
                                <h5 class="card-title font-weight-bold mr-3 mt-3 ml-3 mb-3" style="color: teal">Calon No.
                                    Urut {{ $data->no_urut }}
                                </h5>
                            </div>
                            <div class="col-6">
                                <p class=" mr-3 mt-3 ml-3 mb-3" style="float: right">Periode {{ $data->periode }}</p>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="nama">Nama : </label>
                                    <p>{{ $data->nama }}</p>
                                    <label for="nama">Visi : </label>
                                    <p>{{ $data->visi }}
                                    </p>
                                </div>
                                <div class="col-sm-6">
                                    <img src="{{ asset('storage/' . $data->thumbnail) }}" class="img-thumbnail"
                                        alt="">
                                </div>
                                <div class="col-sm-6">
                                    <a href="#" class="btn btn-light bg-teal btn-sm" data-toggle="modal"
                                        data-target="#editModalCalon{{ $data->id }}"><i class="fas fa-edit">
                                            Edit</i></a> &nbsp;
                                    <a href="#" class="btn btn-light bg-maroon btn-sm delete"
                                        nama="{{ $data->nama }}" id-calon="{{ $data->id }}"> <i
                                            class="fas fa-trash-alt"> Delete</i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addModalCalon" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Calon</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="POST" id="addCalon" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        {{-- <form> --}}
                        <div class="form-group">
                            <label for="no_urut">No. Urut</label>
                            <input type="number" value="{{ old('no_urut') }}" class="form-control" id="no_urut"
                                name="no_urut" placeholder="Masukkan No. Urut Calon">
                            @error('no_urut')
                                <div class="text-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" value="{{ old('nama') }}" class="form-control" id="nama"
                                name="nama" placeholder="Masukkan Nama Calon">
                            @error('nama')
                                <div class="text-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="thumbnail" class="form-label">Foto <i style="font-size: 14px">(Ukuran Foto
                                    Disarankan 3:4)</i></label>
                            <img class="img-preview mb-3 img-fluid col-sm-4" style="width:200px">
                            <input class="form-control" type="file" id="thumbnail" name="thumbnail"
                                onchange="previewImage()">
                            @error('thumbnail')
                                <div class="text-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="visi">Visi</label>
                            <input type="text" value="{{ old('visi') }}" class="form-control" id="visi"
                                name="visi" placeholder="Masukkan Visi Calon">
                            @error('visi')
                                <div class="text-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="periode">Periode</label>
                            <select class="form-control" name="periode" id="periode">
                                <option value="">--- Pilih Periode ---</option>
                                @foreach ($voting as $item)
                                    <option value="{{ $item->periode }}">{{ $item->periode }}</option>
                                @endforeach
                            </select>
                            @error('periode')
                                <div class="text-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-light bg-teal">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($datas as $data)
        <!-- Edits Modal -->
        <div class="modal fade" id="editModalCalon{{ $data->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Data Calon</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="/voting/calon/edit/{{ $data->id }}" method="POST" id="addCalon"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            {{-- <form> --}}
                            <div class="form-group">
                                <label for="no_urut">No. Urut</label>
                                <input type="number" value="{{ $data->no_urut }}" class="form-control"
                                    id="no_urutEdit" name="no_urutEdit" placeholder="Masukkan No. Urut Calon">
                                @error('no_urutEdit')
                                    <div class="text-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" value="{{ $data->nama }}" class="form-control" id="namaEdit"
                                    name="namaEdit" placeholder="Masukkan Nama Calon">
                                @error('namaEdit')
                                    <div class="text-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="thumbnail" class="form-label">Foto <i style="font-size: 14px">(Ukuran Foto
                                        Disarankan 3:4)</i></label>
                                <img class="img-preview-edit{{ $data->id }} mb-3 img-fluid col-sm-4 d-block"
                                    style="width:200px" src="{{ asset('storage/' . $data->thumbnail) }}">
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
                                <label for="visi">Visi</label>
                                <input type="text" value="{{ $data->visi }}" class="form-control" id="visiEdit"
                                    name="visiEdit" placeholder="Masukkan Visi Calon">
                                @error('visi')
                                    <div class="text-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="periode">Periode</label>
                                <select class="form-control" name="periodeEdit" id="periodeEdit">
                                    <option value="{{ $data->periode }}">{{ $data->periode }}</option>
                                    @foreach ($voting as $item)
                                        <option value="{{ $item->periode }}">{{ $item->periode }}</option>
                                    @endforeach
                                </select>
                                @error('periode')
                                    <div class="text-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-light bg-teal">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

@endsection

@section('scripts')
    <script>
        $('.add').click(function() {
            $('#addModalCalon').modal('show')

            $tr = $(this).closest('tr');

            $('#addCalon').attr('action', '/voting/add/calon');
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
    </script>

    <script>
        $('.delete').click(function() {
            var id = $(this).attr('id-calon');
            var nama = $(this).attr('nama');
            swal({
                    title: "Anda Yakin?",
                    text: "Data Calon dengan nama " + nama + " ini akan dihapus",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        window.location = "/voting/delete/calon/" + id;
                        swal("Data berhasil dihapus", {
                            icon: "success",
                        });
                    } else {
                        swal("Data Calon tidak  dihapus");
                    }
                });
        });
    </script>
    {{-- <script>
        $(document).ready(function() {
            $('select[name="periodeV"]').on('change', function() {
                var periodeID = $(this).val();
                if (periodeID) {
                    jQuery.ajax({
                        url: "<?= Request::root() . '/rt/voting/calon/show/' ?>" + periodeID,
                        type: "GET",
                        success: function(res) {
                            console.log('sukses')
                                var html = '';
                                html += '@foreach ($datas as $data)'
                                html +='<div class="col-lg-6 col-md-6 d-flex align-items-stretch mt-4 soal">'
                                html += '    <div class="card shadow bg-body rounded ">'
                                html += '        <div class="row">'
                                html += '            <div class="col-6">'
                                html += '                <h5 class="card-title font-weight-bold mr-3 mt-3 ml-3 mb-3" style="color: teal">Calon No.'
                                html += '                    Urut {{ $data->no_urut }}'
                                html += '                </h5>'
                                html += '            </div>'
                                html += '            <div class="col-6">'
                                html += '                <p class=" mr-3 mt-3 ml-3 mb-3" style="float: right">Periode {{ $data->periode }}</p>'
                                html += '            </div>'
                                html += '        </div>'
                                html += '        <div class="card-body">'
                                html += '            <div class="row">'
                                html += '                <div class="col-sm-6">'
                                html += '                    <label for="nama">Nama : </label>'
                                html += '                    <p>{{ $data->nama }}</p>'
                                html += '                    <label for="nama">Visi : </label>'
                                html += '                    <p>{{ $data->visi }}'
                                html += '                    </p>'
                                html += '                </div>'
                                html += '                <div class="col-sm-6">'
                                html +=  '                    <img src="{{ asset("storage/" . $data->thumbnail) }}" class="img-thumbnail"'
                                html += '                        alt="">'
                                html += '                </div>'
                                html += '                <div class="col-sm-6">'
                                html += '                    <a href="#" class="btn btn-light bg-teal btn-sm" data-toggle="modal"'
                                html +='                        data-target="#editModalCalon{{ $data->id }}"><i class="fas fa-edit">'
                                html += '                            Edit</i></a> &nbsp;'
                                html +='                    <a href="#" class="btn btn-danger btn-sm delete" name="delete" nama="{{ $data->nama }}"'
                                html +='                        id-calon="{{ $data->id }}"> <i class="fas fa-trash-alt"> Delete</i></a>'
                                html += '                </div>'
                                html += '            </div>'
                                html += '        </div>'
                                html += '    </div>'
                                html += '</div>'
                                html += '@endforeach'
                                $('#data_calon').append(html);
                        }
                    });
                }else
                {
                    $('select[name="periodeV"]');
                    $('select[name="periodeV"]').attr("disabled",true).html('');
                    $('select[name="periodeV"]').append('<option value="">--Pilih Periode--</option>');
                }
            });
        });
    </script> --}}
    {{-- <script>
        $(document).ready(function() {
            $('select[name="periodeV"]').on('change', function() {
                $(this).closest('.calon').remove();
            });
        });
    </script> --}}

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
