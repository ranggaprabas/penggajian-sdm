<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    <title>Cetak Gaji SDM</title>
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
        <h2>Daftar Gaji SDM</h2>
        <hr style="width: 50%;border-width: 5px;color:black" />
    </center>

    <table>
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

    <table width="100%" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">Nik</th>
                <th class="text-center">Nama</th>
                <th class="text-center">Jenis Kelamin</th>
                <th class="text-center">Entitas</th>
                <th class="text-center">Jabatan</th>
                <th class="text-center">Gaji Pokok</th>
                <th class="text-center">Transportasi</th>
                <th class="text-center">Uang Makan</th>
                <th class="text-center">Total Gaji</th>
            </tr>
        </thead>
        <tbody>
            @php
                $counter = 1;
            @endphp
            @forelse($items as $item)
                @if ($item->is_admin != 1)
                    <tr>
                        <td>{{ $counter }}</td>
                        <td>{{ $item->nik }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->jenis_kelamin }}</td>
                        <td>{{ $item->nama_entitas ?? '-' }}</td>
                        <td>{{ $item->nama_jabatan ?? '-' }}</td>
                        <td>Rp. {{ number_format($item->gaji_pokok, 0, '', '.') }}</td>
                        <td>Rp. {{ number_format($item->transportasi, 0, '', '.') }}</td>
                        <td>Rp. {{ number_format($item->uang_makan, 0, '', '.') }}</td>
                        @php
                            $total_gaji = $item->gaji_pokok + $item->transportasi + $item->uang_makan;
                        @endphp
                        <td>Rp. {{ number_format($total_gaji, 0, '', '.') }}</td>
                    </tr>
                    @php
                        $counter++;
                    @endphp
                @endif
            @empty
                <tr>
                    <td colspan="9" class="text-center">Data Kosong</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <table width="100%">
        <tr>
            <td></td>
            <td width="200px">
                <p>Semarang, {{ date('d M Y') }} <br /> Manager</p>
                <br />
                <br />
                <p>________________________</p>
            </td>
        </tr>
    </table>

    <script>
        window.print();
    </script>
</body>

</html>
