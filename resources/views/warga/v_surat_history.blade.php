@extends('warga.v_master')
@section('title', 'Surat')
@section('content')

    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row" style="padding-top:3cm; padding-bottom:2cm; margin-top:20px; margin-bottom: 140px;">
            @if (session('success'))
                <div class="alert alert-success alert-block col-md-12 mx-auto" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" style="float: right">×</button>
                </div>
            @endif
            <div class="card col-12 mx-auto shadow rounded">
                <span style="margin:3vh;">
                    <div class="card-header text-white bg-info"
                        style="margin-bottom:3vh; margin-top:3vh; padding-top: 2vh; ">
                        <h4>History Pengajuan Surat</h4>
                    </div>
                </span>
                <div class="card-header">
                    <div class="card-tools">
                        <div class="container-fluid">
                            <div class="col-6 col-12" style="float: right">
                                <form action="/searchKeperluanSurat" method="get" role="searchKeperluanSurat">
                                    {{ csrf_field() }}
                                    <div class="input-group">
                                        <a href="{{ url('/surat/history') }}" class="btn btn-primary">Semua</a>
                                        {{-- <input type="date" class="form-control" name="searchTanggal"
                                            value="{{ $srcTanggal }}"> --}}
                                        <input type="text" class="form-control" name="searchKeperluanSurat"
                                            placeholder="Cari Keperluan Surat"> <span class="input-group-btn">
                                            <button type="submit" class="btn btn-default">
                                                <span class="fas fa-search"></span>
                                            </button>
                                        </span>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive">
                    <table class="table table-hover table-striped  table-sm  text-nowrap" id="dataTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tanggal</th>
                                {{-- <th>No. Surat</th> --}}
                                <th>Keperluan</th>
                                <th class="text-center align-middle">KTP</th>
                                <th class="text-center align-middle">KK</th>
                                <th class="text-center align-middle">Status</th>
                                <th class="text-center align-middle">Action</th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            <?php $no = 1; ?>
                            @foreach ($datas as $key => $data)
                                <tr>
                                    <td class="text-center align-middle">{{ $no }}</td>
                                    <td>{{ $data->created_at }}</td>
                                    {{-- <td>{{ $data->no_surat }}</td> --}}
                                    <td>{{ $data->keperluan }}</td>
                                    <td class="text-center align-middle"> <a href="#" class="btn btn-primary btn-sm"
                                            data-toggle="modal" data-target="#editModalKTP{{ $data->id_surat }}"><i
                                                class="fas fa-eye"> KTP</i></a> &nbsp;</td>
                                    <td class="text-center align-middle"> <a href="#" class="btn btn-primary  btn-sm"
                                            data-toggle="modal" data-target="#editModalKK{{ $data->id_surat }}"><i
                                                class="fas fa-eye"> KK</i></a> &nbsp;</td>
                                    @if ($data->id_status_surat == '1')
                                        <td>Sedang Diproses</td>
                                    @elseif($data->id_status_surat == '2')
                                        <td>Telah disetujui oleh Ketua RT</td>
                                    @elseif($data->id_status_surat == '3')
                                        <td>Telah disetujui oleh Ketua RW</td>
                                    @elseif($data->id_status_surat == '4')
                                        <td>Ditolak oleh ketua RT</td>
                                    @else
                                        <td>Ditolak oleh ketua RW</td>
                                    @endif
                                    @if ($data->id_status_surat == '3')
                                        <td class="text-center align-middle">
                                            <a href="{{ url('/view/surat/' . $data->id_surat) }}" target="_blank"
                                                class="btn btn-success btn-sm"><i class="fas fa-file-download">
                                                    Download</i> </a> &nbsp;
                                        </td>
                                    @elseif($data->id_status_surat == '1')
                                        <td class="text-center align-middle">
                                            <p></p>
                                        </td>
                                    @elseif($data->id_status_surat == '2')
                                        <td class="text-center align-middle">
                                            <p> </p>
                                        </td>
                                    @elseif($data->id_status_surat == '4')
                                        <td>{{ $data->catatan }}</td>
                                    @else
                                        <td>{{ $data->catatan }}</td>
                                    @endif
                                </tr>
                                <?php $no++; ?>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="float-left" style="margin: 10px">
                        Showing
                        {{ $datas->firstItem() }}
                        to
                        {{ $datas->lastItem() }}
                        of
                        {{ $datas->total() }}
                        entries
                    </div>
                    <div class="float-right" style="padding: 10px">
                        {{ $datas->links('pagination::bootstrap-4') }}
                    </div>
                </div>
                <!-- /.card-body -->
                {{-- <div class="col-md-11 mx-auto" >
                <table class="table table-striped table-hover"> 
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">No. Surat</th>
                    <th scope="col">Keperluan</th>
                    <th scope="col">Foto KTP</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                </tr>
                </tbody>
            </table>
            </div> --}}
            </div>
        </div>
    </div>
    <!-- Start Modal -->
    <!-- Edit KTP Modal -->
    @foreach ($datas as $data)
        <div class="modal fade" id="editModalKTP{{ $data->id_surat }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">KTP (Kartu Tanda Penduduk)</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="/surat/ktp/revisi/{{ $data->id_surat }}" method="POST" id="editKTPSurat"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            {{-- <form> --}}
                            <div class="form-group">
                                <label for="showKTP">Foto KTP</label>
                                <img class="img-preview-edit-ktp{{ $data->id_surat }} img-fluid mb-3 col-md-9 rounded mx-auto d-block"
                                    src="{{ asset('storage/' . $data->fileKTP) }}">
                                @if ($data->id_status_surat == '4' || $data->id_status_surat == '5')
                                    <input type="hidden" name="id_surat" value="{{ $data->id }}">
                                    {{-- <input type="hidden" name="status_surat" value="1"> --}}
                                    <input type="hidden" id="oldImageKTP" name="oldImageKTP"
                                        value="{{ $data->fileKTP }}">
                                    <input class="form-control" type="file" id="ktpEdit{{ $data->id_surat }}"
                                        name="ktpEdit" onchange="previewImageEditKTP({{ $data->id_surat }})">
                                @endif
                                @error('ktpEdit')
                                    <div class="text-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            @if ($data->id_status_surat == '4' || $data->id_status_surat == '5')
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End of Modal -->
    @endforeach

    <!-- Start Modal -->
    <!-- Edit KK Modal -->
    @foreach ($datas as $data)
        <div class="modal fade" id="editModalKK{{ $data->id_surat }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">KK ( Kartu Keluarga )</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="/surat/kk/revisi/{{ $data->id_surat }}" method="POST" id="editKKSurat"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            {{-- <form> --}}
                            <div class="form-group">
                                <label for="showKK">Foto KK</label>
                                <img class="img-preview-edit-kk{{ $data->id_surat }} img-fluid mb-3 col-md-9 rounded mx-auto d-block"
                                    src="{{ asset('storage/' . $data->fileKK) }}">
                                @if ($data->id_status_surat == '4' || $data->id_status_surat == '5')
                                    <input type="hidden" name="id_surat" value="{{ $data->id }}">
                                    <input type="hidden" id="oldImageKK" name="oldImageKK"
                                        value="{{ $data->fileKK }}">
                                    <input class="form-control" type="file" id="kkEdit{{ $data->id_surat }}"
                                        name="kkEdit" onchange="previewImageEditKK({{ $data->id_surat }})">
                                @endif
                                @error('kkEdit')
                                    <div class="text-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            @if ($data->id_status_surat == '4' || $data->id_status_surat == '5')
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            @endif
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
        function previewImageEditKTP(id_surat) {

            const image = document.querySelector('#ktpEdit' + id_surat);
            const imagePreview = document.querySelector('.img-preview-edit-ktp' + id_surat);

            imagePreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imagePreview.src = oFREvent.target.result;
            }
        }

        function previewImageEditKK(id_surat) {

            const image = document.querySelector('#kkEdit' + id_surat);
            const imagePreview = document.querySelector('.img-preview-edit-kk' + id_surat);

            imagePreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imagePreview.src = oFREvent.target.result;
            }
        }
    </script>

    {{-- <script>
        $(function() {
            $('#datatable').DataTable({
                responsive: true,
                dom: 'lBfrtip',
                order: [
                    [0, "desc"]
                ],
                lengthChange: true,
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
            });
        });
    </script> --}}
@endsection
