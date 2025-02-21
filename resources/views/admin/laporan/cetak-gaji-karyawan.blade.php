<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    <title>Cetak Slip Gaji SDM</title>
    <style>
        body {
            font-family: Aria;
            color: black;
        }
    </style>
</head>

<body>

    <center>
        <h1>PT. TAMAN MEDIA INDONESIA</h1>
        <h2>Slip Gaji SDM</h2>
        <hr style="width: 50%;border-width: 5px;color:black" />
    </center>

    @foreach ($items as $item)
        <table style="width:100%">
            <tr>
                <td width="20%">Nama SDM</td>
                <td width="30px">:</td>
                <td>{{ $item->nama }}</td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>:</td>
                <td>{{ $item->nik }}</td>
            </tr>
            <tr>
                <td>Entitas</td>
                <td>:</td>
                <td>{{ $item->entitas }}</td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>:</td>
                <td>{{ $item->nama_jabatan ?? '-' }}</td>
            </tr>
            <tr>
                <td>Bulan</td>
                <td>:</td>
                <td>{{ $bulan }}</td>
            </tr>
            <tr>
                <td>Tahun</td>
                <td>:</td>
                <td>{{ $tahun }}</td>
            </tr>
        </table>

        <table class="table table-striped table-bordered mt-3">
            <tr>
                <th class="text-center" width="5%">No</th>
                <th class="text-center">Keterangan</th>
                <th class="text-center">Jumlah</th>
            </tr>
            <tr>
                <td>1</td>
                <td>Tunjangan Jabatan</td>
                <td>Rp. {{ number_format($item->tunjangan_jabatan, 0, '', '.') }}</td>
            </tr>
            @php
                $total_gaji = $item->tunjangan_jabatan;
            @endphp
            <tr>
                <th colspan="2" style="text-align: right;">Total Gaji</th>
                <th>Rp. {{ number_format($total_gaji, 0, '', '.') }}</th>
            </tr>
        </table>

        <table width="100%">
            <tr>
                <td></td>
                <td>
                    <p>SDM</p>
                    <br>
                    <br>
                    <p class="font-weight-bold">{{ $item->nama }}</p>
                </td>
                <td width="200px">
                    <p class="font-weight-bold">Semarang, {{ date('d M Y') }} Manager,</p>
                    <br>
                    <br>
                    <p>_________________</p>
                </td>
            </tr>
        </table>
    @endforeach

    <script>
        window.print()
    </script>
</body>

</html>
