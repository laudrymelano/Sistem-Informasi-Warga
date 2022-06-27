@extends('warga.v_master')
@section('title', 'E-Voting')
@section('content')
    <section class="align-items-center" data-aos="fade-up" data-aos-delay="100">
        <div class="container">
            <div class="row mt-2 justify-content-center align-items-center">
                <img src="{{ asset('assets/img/voting-selesai.png') }}" class="rounded img-fluid" alt="">
                {{-- <div class="col-xl-12 col-lg-12 text-center">
                    <h1>SIAGA</h1>
                    <h2>Terimakasih telah melukan voting</h2>
                </div> --}}
            </div>
        </div>
    </section>
    <section class="align-items-center service section-bg">
        <div class="container" data-aos="fade-up" data-aos-delay="80">
            <div class="row ">
                <div class="col-12 text-center mb-3">
                    <h2>Hasil Perhitungan (Quick Count)</h2>
                    <h5>{{ $judul }} Periode {{ $periode }}</h5>
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
                                    <div class="col-12 text-center">
                                        <a href="javascript:void(0)" class="btn btn-primary btn-md"><i
                                                class="fas fa-vote-yea">
                                                {{ $data->jumlahPemilih }} Suara</i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="align-items-center">
        <div class="container-fluid" data-aos="fade-up" data-aos-delay="80">
            <div class="row">
                <div class="col-9 mx-auto">
                    <div class="card">
                        <div class="card-header bg-primary">
                            <h3 class="card-title font-weight-bold mr-2 mt-2" style="color: white;">Perolehan Suara</h3>
                            <div class="card-tools">
                                {{-- <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button> --}}
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="barChart"
                                    style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        < {{-- {{ dd($dataChart) }} --}} </section>

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
                        label: "Perolehan Suara",
                        data: cData.data,
                        backgroundColor: ['#008080', '#4682B4', '#4682B4', '#4682B4', '#4682B4'],
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
                    type: 'bar',
                    data: pieData,
                    options: pieOptions
                })
            </script>

        @endsection
