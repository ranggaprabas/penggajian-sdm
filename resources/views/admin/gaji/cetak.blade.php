<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Gaji SDM</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            color: black;
        }

        .container {
            margin: 20px;
        }

        .header {
            text-align: center;
        }

        .title {
            font-size: 24px;
            font-weight: bold;
        }

        .subtitle {
            font-size: 20px;
            font-weight: bold;
        }

        .separator {
            width: 50%;
            border-width: 5px;
            color: black;
            margin: 10px auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        thead tr:nth-child(odd) {
            background-color: white;
        }

        tr:nth-child(odd) {
            background-color: #f2f2f2;
            /* Warna latar belakang untuk baris ganjil */
        }

        tr:nth-child(even) {
            background-color: white;
            /* Warna latar belakang untuk baris genap */
        }

        tr.no-background {
            background-color: transparent;
            /* Atau biarkan kosong agar menggunakan warna default */
        }

        tr.footer {
            background-color: white;
        }

        ul {
            list-style-position: inside;
            padding: 3;
            margin: 0;
        }

        li {
            text-align: left;
        }

        .footer {
            margin-top: 20px;
        }

        .signature {
            width: 200px;
            margin: 0 auto;
        }

        .date {
            border-collapse: collapse;
            width: 100%;
        }

        .date td {
            padding: 8px;
            border: none;
            text-align: left;
        }

        .no-background td {
            background-color: transparent;
        }

        .separator td {
            border-top: 1px solid #ccc;
            /* Warna abu-abu */
        }
    </style>
</head>

<body>
    @if (auth()->user()->status == 1)
        <div style="position: absolute; top: 20px; right: 5px;">
            <img src="{{ public_path('images/tamanmediaindonesia.png') }}" alt="PT. TAMAN MEDIA INDONESIA Logo"
                width="130">
        </div>
        <center>
            <h2 style="margin-right: 10px;">PT. TAMAN MEDIA INDONESIA</h2>
            <h3>Daftar Gaji SDM</h3>
            <hr style="width: 50%;border-width: 5px;color:rgb(235, 235, 235)" />
        </center>
    @else
        <div style="position: absolute; top: 20px; right: 5px;">
            @if (auth()->user()->entitas && auth()->user()->entitas->image)
                <!-- Jika entitas pengguna memiliki gambar, tampilkan gambar entitas -->
                <img src="{{ public_path('storage/' . auth()->user()->entitas->image) }}"
                    alt="{{ auth()->user()->entitas->nama }} Logo" width="130">
            @else
                <!-- Default image jika entitas tidak memiliki gambar -->
                <img src="{{ public_path('images/default.png') }}" alt="Default Logo" width="130">
            @endif
        </div>
        <center>
            <h2 style="margin-right: 10px;">
                {{ auth()->user()->entitas ? auth()->user()->entitas->nama : 'Nama Entitas' }}</h2>
            <h3>Daftar Gaji SDM</h3>
            <hr style="width: 50%;border-width: 5px;color:rgb(235, 235, 235)" />
        </center>
    @endif

    <table class="date">
        <tr class="no-background">
            <td width="15%">Bulan</td>
            <td width="10px">:</td>
            <td>{{ $namaBulan }}</td>
        </tr>
        <tr class="no-background">
            <td>Tahun</td>
            <td>:</td>
            <td>{{ $tahun }}</td>
        </tr>
    </table>

    <table width="100%" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">Nama</th>
                <th class="text-center">Entitas</th>
                <th class="text-center">Divisi</th>
                <th class="text-center">Jabatan</th>
                <th class="text-center">Penerimaan/Tunjangan</th>
                <th class="text-center">Potongan</th>
                <th class="text-center">Take Home Pay</th>
            </tr>
        </thead>
        <tbody>
            @php
                $counter = 1;
            @endphp
            @forelse($items as $item)
                <tr>
                    <td>{{ $counter }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->entitas }}</td>
                    <td>{{ $item->divisi }}</td>
                    <td>{{ $item->jabatan }}</td>
                    <td>
                        @if ($item->tunjangan)
                            @php
                                $tunjangan = json_decode($item->tunjangan, true);
                            @endphp
                            <ul>
                                <li>
                                    Gaji Pokok:
                                    Rp. {{ number_format($item->gaji_pokok, 0, '', '.') }}
                                </li>
                                <li>
                                    Tj. Jabatan:
                                    Rp. {{ number_format($item->tunjangan_jabatan, 0, '', '.') }}
                                </li>
                                @if (is_array($tunjangan) && count($tunjangan) > 0)
                                    @php
                                        $total_tunjangan = array_sum(array_column($tunjangan, 'nilai_tunjangan'));
                                        $jumlah_tunjangan = $item->tunjangan_jabatan + $total_tunjangan;
                                    @endphp
                                    @foreach ($tunjangan as $t)
                                        <li>Tj. {{ $t['nama_tunjangan'] ?? '-' }}: Rp.
                                            {{ number_format($t['nilai_tunjangan'], 0, '', '.') }}
                                        </li>
                                    @endforeach
                                @else
                                    @php
                                        $jumlah_tunjangan = $item->tunjangan_jabatan;
                                    @endphp
                                @endif
                            </ul>
                        @else
                            Tidak ada tunjangan.
                        @endif
                    </td>
                    <td>
                        @if ($item->potongan)
                            @php
                                $potongan = json_decode($item->potongan, true);
                            @endphp
                            <ul>
                                @if (is_array($potongan) && count($potongan) > 0)
                                    @php
                                        $total_potongan = array_sum(array_column($potongan, 'nilai_potongan'));
                                        $jumlah_potongan = $total_potongan;
                                    @endphp
                                    @foreach ($potongan as $t)
                                        <li>{{ $t['nama_potongan'] ?? '-' }}: Rp.
                                            {{ number_format($t['nilai_potongan'], 0, '', '.') }}
                                        </li>
                                    @endforeach
                                @else
                                    @php
                                        $jumlah_potongan = 0; // Set potongan menjadi 0 jika tidak ada data potongan
                                    @endphp
                                    <li>-: Rp. 0</li>
                                @endif
                            </ul>
                        @else
                            Tidak ada potongan.
                        @endif
                    </td>
                    @php
                        $take_home_pay = $jumlah_tunjangan - $jumlah_potongan;
                    @endphp
                    <td>Rp. {{ number_format($take_home_pay, 0, '', '.') }}</td>
                </tr>
                @php
                    $counter++;
                @endphp
            @empty
                <tr>
                    <td colspan="9" class="text-center">Data Kosong</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <table width="100%" style="border: none;">
        <tr class="footer">
            <td style="border: none;"></td>
            <td width="200px" style="border: none;">
                <p>Semarang, {{ date('d M Y') }} <br /> Manager</p>
                <br />
                <br />
                <p>________________________</p>
            </td>
        </tr>
    </table>
</body>

</html>
