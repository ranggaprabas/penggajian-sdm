<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Pinjaman SDM</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            color: black;
        }

        .container {
            margin: 20px;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header .header-text {
            flex-grow: 1;
            text-align: left;
            margin-left: 300px;
        }

        .header .header-text h2 {
            font-size: 20px;
            margin: 0;
        }

        .center-text {
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
        .indented {
            text-indent: 35px;
        }
    </style>
</head>

<body>
    @foreach ($items as $item)
        @php
            // Dapatkan data entitas berdasarkan nama
            $entitas = \App\Models\Entitas::where('nama', $item->entitas)->first();
            setlocale(LC_TIME, 'id_ID.UTF-8');
            $tanggalCetak = strftime('%d %B %Y', strtotime('now'));
        @endphp

        @if ($entitas)
        <div style="position: absolute; top: 20px; left: 17px;">
            <img src="{{ public_path('storage/' . $entitas->image) }}" alt="{{ $entitas->nama }} Logo" width="170">
        </div>
            <div class="header">
                <div class="header-text">
                    <h2>{{ $entitas->nama }}</h2>
                    <p>{{ $entitas->alamat }}</p>
                </div>
            </div>

            <h3 class="center-text">SURAT PERMOHONAN PEMINJAMAN UANG</h3>
        @endif
        <table class="date">
            <tr class="no-background">
                <td><strong>Hal: Pengajuan Permohonan Pinjaman Uang</strong></td>
            </tr>
        </table>
        <table class="date">
            <tr class="no-background">
                <td>Kepada</td>
            </tr>
            <tr class="no-background">
                <td>Yth. Pimpinan PT. Taman Media Indonesia</td>
            </tr>
            <tr class="no-background">
                <td>Di</td>
            </tr>
            <tr class="no-background">
                <td>Tempat</td>
            </tr>
        </table>
        <table class="date">
            <tr class="no-background">
                <td class="indented">Sehubungan dengan keperluan mendesak yang saya hadapi, dengan ini saya mengajukan permohonan
                    pinjaman uang, saya yang bertanda tangan di bawah ini:</td>
            </tr>
        </table>
        <table style="width:100%" class="date">
            <tr class="no-background">
                <td width="15%">Nama</td>
                <td width="10px">:</td>
                <td>{{ $item->nama }}</td>
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
                <td>Keterangan</td>
                <td>:</td>
                <td>{{ $item->keterangan }}</td>
            </tr>
            <tr class="no-background">
                <td>Status</td>
                <td>:</td>
                <td>{{ $item->status }}</td>
            </tr>
        </table>

        <table class="date">
            <tr class="no-background">
                <td>Dengan ini mengajukan permohonan pinjaman uang sebesar Rp. {{ number_format($item->nilai_pinjaman, 0, '', '.') }}. Uang tersebut akan digunakan untuk keperluan pribadi yang mendesak.</td>
            </tr>
        </table>

        <table class="date">
            <tr class="no-background">
                <td>Demikian surat permohonan ini dibuat. Atas Perhatiannya saya ucapkan terima kasih.</td>
            </tr>
        </table>

        <table width="100%" style="border: none;">
            <tr class="footer">
                <td style="border: none; text-align: left;">
                </td>
                <td width="200px" style="border: none;">
                    <p class="font-weight-bold">Semarang, {{ $tanggalCetak }}</p>
                    <br>
                    <p>_________________</p>
                    <p><strong>{{ $item->nama }}</strong></p>
                </td>
            </tr>
        </table>
    @endforeach
</body>

</html>
