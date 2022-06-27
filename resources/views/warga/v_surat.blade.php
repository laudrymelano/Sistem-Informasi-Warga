@extends('warga.v_master')
@section('title', 'Surat')
@section('content')

    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row" style="padding-top:3cm; padding-bottom:2cm">
            @if (session('success'))
                <div class="alert alert-success col-md-9 mx-auto" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" style="float: right">X</button>
                </div>
            @endif
            <div class="card col-md-9 mx-auto shadow rounded">
                <span style="margin:3vh;">
                    <div class="card-header text-white bg-info"
                        style="margin-bottom:3vh; margin-top:3vh; padding-top: 2vh; ">
                        <h4>PEMBUATAN SURAT PENGANTAR/KETERANGAN</h4>
                    </div>
                    <h5>Berikut persyaratan berkas yang harus dipenuhi:</h5>
                    <p>1. KTP (Kartu Tanda Penduduk).</br>
                        2. KK (Kartu Keluarga). </br> <br>
                        Note :</br>
                        <i style="color: red">Berkas KTP atau KK harus yang terbaru</br></i>
                    </p>
                </span>
                <div class="col-md-12 text-center" style="margin-bottom:3vh;">
                    <button id="lanjut" class="btn btn-icon btn-outline-primary rounded-pill btn-sm">Oke, Saya
                        Mengerti</button>
                </div>
            </div>
            <div id="form-surat" class="card col-md-9 mx-auto shadow rounded"
                style="margin-top:20px; margin-bottom: 20px; display: none" x>
                <form style="margin:3vh;" action="{{ url('surat/post') }}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id_warga" value="{{ Auth::guard('user_warga')->user()->id }}">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-9 mb-3">
                            <label>Keperluan : </label>
                            <select class="form-select" name="keperluan" aria-label="Default select example">
                                <option selected>-- Pilihan --</option>
                                <option value="Pendaftaran Penduduk">Pendaftaran Penduduk</option>
                                <option value="SKCK">SKCK</option>
                                <option value="Pendaftaran Kelahiran">Pendaftaran Kelahiran</option>
                                <option value="Berpergian">Berpergian</option>
                                <option value="Pendaftaran Nikah/Talak">Pendaftaran Nikah/Talak</option>
                                <option value="Pengantar untuk membuat SIM">Pengantar untuk membuat SIM</option>
                                <option value="Permohonan Izin Usaha">Permohonan Izin Usaha</option>
                                <option value="Keterangan Domisili">Keterangan Domisili</option>
                                <option value="KTP">KTP</option>
                                <option value="KK">KK</option>
                                <option value="Surat Keterangan Kenal Lahir">Surat Keterangan Kenal Lahir</option>
                                <option value="Permohonan Izin Keramaian">Permohonan Izin Keramaian</option>
                                <option value="Surat Keterangan Tanah">Surat Keterangan Tanah</option>
                                <option value="Mutasi Tanah, Jual Beli/Hibah/Waris">Mutasi Tanah, Jual Beli/Hibah/Waris
                                </option>
                                <option value="Surat Keterangan Belum Pernah Menikah">Surat Keterangan Belum Pernah Menikah
                                </option>
                                <option value="Permohonan Izin Bangunan(IMB)">Permohonan Izin Bangunan(IMB)</option>
                                <option value="Surat Keterangan Tidak Mampu (SKTM)">Surat Keterangan Tidak Mampu (SKTM)
                                </option>
                                <option value="Pindah Alamat">Pindah Alamat</option>
                            </select>
                            @error('keperluan')
                                <div class="text-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>
                        <div class="form-group col-md-9 mb-3">
                            <label for="keperluan-lainnya" class="form-label">Lainnya <i
                                    style="color: red; font-size: 13px">(Jika pilihan tidak tersedia pada opsi
                                    diatas)</i></label>
                            <input type="text" name="keperluan_lainnya" class="form-control" id="lainnya">
                            @error('keperluan_lainnya')
                                <div class="text-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="keterangan" class="form-label">Keterangan : </label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
                            @error('keterangan')
                                <div class="text-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="KTP" class="form-label">Foto KTP</label>
                            <input class="form-control" name="fileKTP" accept="image/*" type="file" id="KTP">
                            @error('fileKTP')
                                <div class="text-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mb-4">
                            <label for="KK" class="form-label">Foto KK</label>
                            <input class="form-control" name="fileKK" accept="image/*" type="file" id="KK">
                            @error('fileKK')
                                <div class="text-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-gorup mb-3">
                            <button class="btn btn-icon btn-primary rounded-pill " type="submit">
                                <span class="btn-inner--icon"><i class="ni ni-check-bold"></i></span>
                                <span class="btn-inner--text">Submit</span>
                            </button>
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.0.js"></script>
    <script type="text/javascript">
        function showForm() {
            $("div#form-surat").fadeIn();
            $("button#lanjut").fadeOut();
        }

        $("button#lanjut").click(showForm);
    </script>

@endsection
