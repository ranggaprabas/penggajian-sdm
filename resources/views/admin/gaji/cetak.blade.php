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
            border-top: 1px solid #ccc; /* Warna abu-abu */
        }
    </style>
</head>

<body>
    <center>
        <h1>PT. TAMAN MEDIA INDONESIA</h1>
        <h2>Daftar Gaji SDM</h2>
        <hr style="width: 50%;border-width: 5px;color:rgb(235, 235, 235)" />
    </center>

    <table class="date">
        <tr class="no-background">
            <td>Bulan   :   {{$namaBulan}}</td>
        </tr>
        <tr class="separator">
            <td></td>
        </tr>
        <tr class="no-background">
            <td>Tahun   :  {{ $tahun }}</td>
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
                <th class="text-center">Tunjangan</th>
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
                                    Jabatan:
                                    Rp. {{ number_format($item->tunjangan_jabatan, 0, '', '.') }}
                                </li>
                                @if (is_array($tunjangan) && count($tunjangan) > 0)
                                    @php
                                        $total_tunjangan = array_sum(array_column($tunjangan, 'nilai_tunjangan'));
                                        $jumlah_tunjangan = $item->tunjangan_jabatan + $total_tunjangan;
                                    @endphp
                                    @foreach ($tunjangan as $t)
                                        <li>{{ $t['nama_tunjangan'] ?? '-' }}: Rp.
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
