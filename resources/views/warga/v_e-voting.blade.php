@extends('warga.v_master')
@section('title', 'E-Voting')
@section('content')

    @if ($datas->isEmpty())
        <section class="align-items-center" data-aos="fade-up" data-aos-delay="100">
            <div class="container">
                <div class="row mt-2 justify-content-center align-items-center">
                    <img src="{{ asset('assets/img/voting-not.png') }}" class="rounded img-fluid" alt="">
                    {{-- <div class="col-xl-12 col-lg-12 text-center">
                        <h1>SIAGA</h1>
                        <h2>E-Voting Belum tersedia di RT Anda</h2>
                    </div> --}}
                </div>
            </div>
        </section>
    @else
        <section class="align-items-center mt-2">
            <div class="container" data-aos="fade-up">
                <div class="row ">
                    <div class="col-12 text-center mt-2">
                        <h2>{{ $judul }} Periode {{ $periode }}</h2>
                        <h4>Segera Voting Calon Terbaik Kamu</h4>
                    </div>
                </div>
                <div class="row">
                    @foreach ($datas as $data)
                        <div class="col-lg-4 col-md-4 align-items-stretch d-flex mt-4">
                            <div class="card">
                                <img src="{{ asset('storage/' . $data->thumbnail) }}" class="card-img-top img-thumbnail"
                                    alt="thumbnail">
                                <div class="card-body">
                                    <p class="text-center" style="font-size: 14px">Calon No. {{ $data->no_urut }}</p>
                                    <h5 class="card-title text-center">{{ $data->nama }}</h5>
                                    <hr class="mx-auto" style="width:30%">
                                    <div class="row">
                                        <div class="col-6 mx-auto">
                                            <a href="#" class="btn btn-success btn-sm" data-toggle="modal"
                                                data-target="#detailCalon{{ $data->id }}"><i class="fas fa-eye">
                                                    Detail</i></a>
                                            <a href="#" class="btn btn-primary btn-sm voting" update='vote'
                                                no_urut="{{ $data->no_urut }}" id-calon="{{ $data->id }}"
                                                id-voting="{{ $data->id_voting }}"><i
                                                    class="fas
                                            fa-check">
                                                    Pilih</i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif


    @foreach ($datas as $data)
        <!-- Modal -->
        <div class="modal fade" id="detailCalon{{ $data->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Calon No. {{ $data->no_urut }}</h5>
                        {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button> --}}
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12"><label><b>Nama : </b></label>
                                    <p>{{ $data->nama }}</p>
                                </div>
                                <div class="col-12"><label><b>Umur : </b></label>
                                    <p>30</p>
                                </div>
                                <div class="col-12"><label><b>Visi : </b></label>
                                    <p>{{ $data->visi }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@section('scripts')
    <script>
        $('.voting').click(function() {
            var id = $(this).attr('id-calon');
            var id_voting = $(this).attr('id-voting');
            var update = $(this).attr('update');
            var no_urut = $(this).attr('no_urut');
            swal({
                    title: "Anda Yakin?",
                    text: "Memilih Calon dengan No. Urut " + no_urut +
                        ". Pastikan Anda memilih calon dengan benar, karena voting hanya bisa dilakukan 1 kali dan tidak bisa diubah",
                    icon: "warning",
                    buttons: [true, "Ya, Saya Yakin"],
                    dangerMode: false,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        window.location = "/evoting/" + update + "/" + id + "/" + id_voting;
                        swal("Selamat, suara Anda telah tercatat", {
                            icon: "success",
                        });
                    }
                    // else {
                    //     swal("Status surat belum di update");
                    // }
                });
        });
    </script>

@endsection
