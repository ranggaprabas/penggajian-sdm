<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    <title>Cetak Slip Gaji SDM</title>
    <style>
        body {
            font-family: 'Times new roman';
            color: black;
        }
    </style>
</head>

<body>
    <div style="position: absolute; top: 20px; right: 20px;">
        <img src="{{ asset('images/tamanmediaindonesia.png') }}" alt="PT. TAMAN MEDIA INDONESIA Logo" width="180">
    </div>
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
                <td>{{ $namaBulan }}</td>
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
                <td>Gaji Pokok</td>
                <td>Rp. {{ number_format($item->gaji_pokok, 0, '', '.') }}</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Tunjangan Transportasi</td>
                <td>Rp. {{ number_format($item->transportasi, 0, '', '.') }}</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Uang Makan</td>
                <td>Rp. {{ number_format($item->uang_makan, 0, '', '.') }}</td>
            </tr>
            @php
                $total_gaji = $item->gaji_pokok + $item->transportasi + $item->uang_makan;
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
