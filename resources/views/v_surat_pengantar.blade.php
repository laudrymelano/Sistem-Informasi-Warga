<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Pengantar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style type="text/css">
        table {
            border-style: double;
            border-width: 3px;
            border-color: white;
        }

        body {
            font-family: 'Times New Roman' !important;
            font-size: 16px;
        }

        .border-bottom {
            border-bottom: 1px solid black !important;
        }

        .border {
            border: 1px solid black !important;
        }

        table tr .text2 {
            text-align: right;
            font-size: 14px;
        }

        table tr .text {
            text-align: center;
            font-size: 14px;
        }

        table tr td {
            font-size: 14px;
        }

        .border-right {
            border-right: 1px solid black !important;
        }

        .border-left {
            border-left: 1px solid black !important;
        }

        .nowrap {
            white-space: nowrap;
        }

        .l-s {
            letter-spacing: 1px;
        }

        .f-s {
            font-size: 16px;
        }

        @media print {
            footer {
                display: none;
            }

            header {
                display: none;
            }

            @page {
                margin: 0;
                size: 7.27in 9.69in;
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid mt-3 d-flex justify-content-center ">
        <div class="row ">
            <div class="col-12">
                {{-- @dump(json_encode(explode('/', $warga->no_surat))) --}}
                <table class="table border table-borderless mb-0" style="border-bottom: 0px solid black!important">
                    <tr>
                        <td class="col-4 text-center"><img src="{{ asset('assets/img/depok.png') }}" width="100"
                                height="100"></td>
                        <td class="col-4 text-center ">
                            <div style="font-size: 17px" class="fw-bold nowrap text-uppercase l-s">
                                Rukun Tetangga RT.{{ $warga->rt }} RW.007 <br>
                                Kel. {{ $warga->kelurahan }} Kec. {{ $warga->kecamatan }} <br>
                                Kota Depok
                            </div>
                            <div style="font-size: 11px">
                                Jl. flamboyan no.37 Kel. Depok Kec. Pancoran Mas, 16431
                            </div>
                            {{-- <center>
                                <font size="4">Rukun Tetangga RT.003 RW.007</font><br>
                                <font size="3">Kel. Depok, Kec. Pancoran Mas, Kota Depok</font><br>
                                <font size="2"><i>Jl. flamboyan no.37 Kel. Depok Kec. Pancoran Mas, 16431</i></font>
                            </center> --}}
                        </td>
                        <td class="col-4">
                            <div class="d-flex justify-content-end">{!! DNS2D::getBarcodeSVG(url('/cek/surat'), 'QRCODE', 2, 2) !!}</div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <hr class="border-bottom">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-uppercase text-center fw-bolder h6"> <u>SURAT PENGANTAR /
                                KETERANGAN</u> </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-center h7">No, {{ $warga->no_surat }}</td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <div class="py-3">
                                Kepada Yth.<br>Bapak/Ibu Lurah Depok<br>Di tempat
                            </div>
                            {{-- <font size="2">Kepada Yth.<br>Bapak/Ibu Lurah Depok<br>Di tempat</font> --}}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">Dengan ini kami hadapkan,</td>
                    </tr>
                </table>
                <table class="border table-borderless" width="650"
                    style="border-top: 0px solid black!important; border-bottom: 0px solid black!important;">
                    <tr>
                        <td class="col-3">
                            <div class="f-s ms-2">Nama</div>
                        </td>
                        <td class="col-8">
                            <div class="f-s">: {{ $warga->nama }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="f-s ms-2">Tempat / Tanggal Lahir</div>
                        </td>
                        <td>
                            <div class="f-s">: {{ $warga->ttl }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="f-s ms-2">Jenis Kelamin</div>
                        </td>
                        <td>
                            <div class="f-s ">: {{ $warga->jenis_kelamin }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="f-s ms-2">Agama</div>
                        </td>
                        <td>
                            <div class="f-s ">: {{ $warga->agama }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="f-s ms-2">Kewarganegaraan</div>
                        </td>
                        <td>
                            <div class="f-s ">: WNI</div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="f-s ms-2">Pekerjaan</div>
                        </td>
                        <td>
                            <div class="f-s ">: {{ $warga->pekerjaan }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="f-s ms-2">Alamat Tempat Tinggal</div>
                        </td>
                        <td>
                            <div class="f-s ">: {{ $warga->alamat }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="f-s ms-2">Terdaftar pada KK No</div>
                        </td>
                        <td>
                            <div class="f-s ">: {{ $warga->no_kk }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="f-s ms-2 py-3">KEPERLUAN</div>
                        </td>
                        <td>
                            <div class="f-s">: Ingin membuat {{ $warga->keperluan }}, karena
                                {{ $warga->keterangan }}</div>
                        </td>
                    </tr>
                </table>
                <table class="border table-borderless" width="650"
                    style="border-top: 0px solid black!important; border-bottom: 0px solid black!important;"
                    width="625">
                    <tr>
                        <td>
                            <div class="ms-2 pb-5">Demikian Surat Pengantar ini kami berikan, agar mendapat bantuan
                                seperlunya, guna proses tindak lanjut ke tingkat selanjutnya.</div>
                        </td>
                    </tr>
                </table>
                </table>
                <table class="border table-borderless" style="border-top: 0px solid black!important;" width="650">
                    <tr>
                        <div>
                            <td class="text" align="center">Ketua RT.{{ $warga->rt }}<br><br><br><br>Bpk
                                Fauzy.s.kom</td>
                        </div>
                        <td width="200"></td>
                        <div>
                            <td class="text" align="center">Ketua RW.007<br><br><br><br>Bpk Fauzy.s.kom</td>
                        </div>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <div class="pb-4"></div>
                        </td>
                    </tr>
                </table>

            </div>
        </div>
    </div>

    <script>
        window.onafterprint = window.close;
        window.print();
    </script>
</body>

</html>
