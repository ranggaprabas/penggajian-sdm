<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Slip Gaji SDM</title>
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
    @foreach ($items as $item)
        @php
            // Dapatkan data entitas berdasarkan nama
            $entitas = \App\Models\Entitas::where('nama', $item->entitas)->first();
        @endphp

        @if ($entitas)
            <div style="position: absolute; top: 20px; right: 5px;">
                <img src="{{ public_path('storage/' . $entitas->image) }}" alt="{{ $entitas->nama }} Logo" width="130">
            </div>
            <center>
                <h2>{{ $entitas->nama }}</h2>
                <h3>Slip Gaji SDM</h3>
                <hr style="width: 50%;border-width: 5px;color:rgb(235, 235, 235)" />
            </center>
        @endif
        <table style="width:100%" class="date">
            <tr class="no-background">
                <td width="15%">Nama SDM</td>
                <td width="10px">:</td>
                <td>{{ $item->nama }}</td>
            </tr>
            <tr class="no-background">
                <td width="15%">Email</td>
                <td width="10px">:</td>
                <td>{{ $item->email }}</td>
            </tr>
            <tr class="no-background">
                <td>NIK</td>
                <td>:</td>
                <td>{{ $item->nik }}</td>
            </tr>
            <tr class="no-background">
                <td>Entitas</td>
                <td>:</td>
                <td>{{ $item->entitas }}</td>
            </tr>
            <tr class="no-background">
                <td>Divisi</td>
                <td>:</td>
                <td>{{ $item->divisi }}</td>
            </tr>
            <tr class="no-background">
                <td>Jabatan</td>
                <td>:</td>
                <td>{{ $item->jabatan }}</td>
            </tr>
            <tr class="no-background">
                <td>Bulan</td>
                <td>:</td>
                <td>{{ $namaBulan }}</td>
            </tr>
            <tr class="no-background">
                <td>Tahun</td>
                <td>:</td>
                <td>{{ $tahun }}</td>
            </tr>
        </table>

        <table class="table table-striped table-bordered mt-3">
            <tr>
                <th class="text-center" width="5%">No</th>
                <th class="text-center" width="40%">Tunjangan (+)</th>
                <th class="text-center" width="40%">Jumlah</th>
            </tr>
            <tr>
                <td>1</td>
                <td>Tj. Jabatan</td>
                <td>Rp. {{ number_format($item->tunjangan_jabatan, 0, '', '.') }}</td>
            </tr>
            @php
                $totalTunjangan = $item->tunjangan ? json_decode($item->tunjangan, true) : [];
            @endphp
            @foreach ($totalTunjangan as $key => $tun)
                <tr>
                    <td>{{ $loop->iteration + 1 }}</td>
                    <td>
                        Tj. {{ $tun['nama_tunjangan'] }}
                        <br>
                        @if (!empty($tun['note_tunjangan']))
                            ({{ $tun['note_tunjangan'] }})
                        @endif
                    </td>
                    <td>Rp. {{ number_format($tun['nilai_tunjangan'], 0, '', '.') }}</td>
                </tr>
            @endforeach
            @php
                $total_tunjangan = $item->tunjangan_jabatan + array_sum(array_column($totalTunjangan, 'nilai_tunjangan'));
            @endphp
            <tr>
                <th colspan="2" style="text-align: right;">Total Tunjangan</th>
                <th>Rp. {{ number_format($total_tunjangan, 0, '', '.') }}</th>
            </tr>

        </table>

        <table class="table table-striped table-bordered mt-3">
            <tr>
                <th class="text-center" width="5%">No</th>
                <th class="text-center" width="40%">Potongan (-)</th>
                <th class="text-center" width="40%">Jumlah</th>
            </tr>
            @php
                $totalPotongan = $item->potongan ? json_decode($item->potongan, true) : [];
            @endphp
            @foreach ($totalPotongan as $key => $pot)
                <tr>
                    <td>{{ $loop->iteration + 0 }}</td>
                    <td>
                        {{ $pot['nama_potongan'] }}
                        <br>
                        @if (!empty($pot['note_potongan']))
                            ({{ $pot['note_potongan'] }})
                        @endif
                    </td>
                    <td>Rp. {{ number_format($pot['nilai_potongan'], 0, '', '.') }}</td>
                </tr>
            @endforeach
            @php
                $total_potongan = array_sum(array_column($totalPotongan, 'nilai_potongan'));
            @endphp
            <tr>
                <th colspan="2" style="text-align: right;">Total Potongan</th>
                <th>Rp. {{ number_format($total_potongan, 0, '', '.') }}</th>
            </tr>
            @php
                $total_gaji = $total_tunjangan - $total_potongan;
            @endphp
            <tr>
                <th colspan="2" style="text-align: right;">Take Home Pay</th>
                <th>Rp. {{ number_format($total_gaji, 0, '', '.') }}</th>
            </tr>
        </table>


        <table width="100%" style="border: none;">
            <tr class="footer">
                <td style="border: none; text-align: left;">
                    <p>SDM</p>
                    <br>
                    <br>
                    <p class="font-weight-bold">{{ $item->nama }}</p>
                </td>
                <td width="200px" style="border: none;">
                    <p class="font-weight-bold">Semarang, {{ date('d M Y') }} Manager,</p>
                    <br>
                    <br>
                    <p>_________________</p>
                </td>
            </tr>
        </table>
    @endforeach
</body>

</html>
