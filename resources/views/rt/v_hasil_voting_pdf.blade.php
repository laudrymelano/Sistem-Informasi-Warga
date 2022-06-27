<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>SIAGA</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <style type="text/css">
        table tr td,
        table tr th {
            font-size: 9pt;
        }
    </style>
    <center>
        <h4>Hasil {{ $judul }} Periode {{ $periode }} </h4>
    </center>
    <br>

    <table class='table table-bordered'>
        <thead>
            <tr>
                <th class="text-center align-middle">No. Urut</th>
                <th>Nama Calon</th>
                <th class="text-center align-middle">Jumlah Suara</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datas as $data)
                <tr>
                    <td class="text-center align-middle">{{ $data->no_urut }}</td>
                    <td>{{ $data->nama }}</td>
                    <td class="text-center align-middle">{{ $data->jumlahPemilih }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <br>
    <table class='table table-bordered'>
        <thead>
            <tr>
                <th>Total Pemilih</th>
                <th>Total Suara Masuk</th>
                <th>Total Golput</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $tPemilih }}</td>
                <td>{{ $tSuara }}</td>
                <td>{{ $tGolput }}</td>
            </tr>
        </tbody>
    </table>

</body>

</html>
