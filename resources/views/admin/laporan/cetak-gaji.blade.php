<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slip Gaji</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header img {
            width: 200px;
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

        .header .header-text p {
            font-size: 10px;
            margin: 5px 0;
        }

        .details {
            display: flex;
            justify-content: space-between;
        }

        .details div {
            width: 15%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border: none;
        }

        th {
            background-color: #f2f2f2;
            text-align: center;
        }

        .profile {
            background-color: #ffffff;
        }

        .highlightJumlah {
            background-color: #ffffff;
            color: rgb(0, 0, 0);
        }

        .highlight {
            background-color: #062256;
            color: white;
        }

        .spacing {
            display: inline-block;
            width: 10px;
        }

        .align-right {
            float: right;
        }

        .center-text {
            text-align: center;
        }

        thead tr:nth-child(odd) {
            background-color: white;
        }

        tbody tr:nth-child(odd) {
            background-color: #ffffff;
        }

        tbody tr:nth-child(even) {
            background-color: #d9edf7;
        }

        .currency {
            display: flex;
            justify-content: flex-end;
            gap: 80px;
        }

        .currency span {
            display: inline-block;
            width: 50px;
            text-align: right;
        }

        .footer {
            margin-top: 20px;
        }

        .profile-table {
            width: 100%;
        }

        .profile-table td {
            padding: 4px;
        }
    </style>
</head>

<body>
    @foreach ($items as $item)
        @php
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
                    <p>Jl. Bina Remaja No. 6 Banyumanik Semarang</p>
                </div>
            </div>

            <h2 class="center-text">SLIP GAJI</h2>

            <table class="profile-table">
                <tr>
                    <td class="profile" width="15%">Nama SDM</td>
                    <td class="profile" width="10px">:</td>
                    <td class="profile" width="35%">{{ $item->nama }}</td>
                    <td class="profile" width="15%"></td>
                    <td class="profile" width="15%">NIK</td>
                    <td class="profile" width="10px">:</td>
                    <td class="profile">{{ $item->nik }}</td>
                </tr>
                <tr>
                    <td class="profile">Jabatan</td>
                    <td class="profile">:</td>
                    <td class="profile">{{ $item->jabatan }}</td>
                    <td class="profile" width="15%"></td>
                    <td class="profile">Bulan</td>
                    <td class="profile">:</td>
                    <td class="profile">{{ $namaBulan }} {{ $tahun }}</td>
                </tr>
            </table>

            <table>
                <thead>
                    <tr>
                        <th class="highlight center-text" colspan="2">PENERIMAAN</th>
                        <th class="highlight center-text" colspan="2">POTONGAN</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalTunjangan = $item->tunjangan ? json_decode($item->tunjangan, true) : [];
                        $totalPotongan = $item->potongan ? json_decode($item->potongan, true) : [];
                        $maxRows = max(count($totalTunjangan) + 2, count($totalPotongan));
                    @endphp

                    @for ($i = 0; $i < $maxRows; $i++)
                        <tr>
                            @if ($i == 0)
                                <td>
                                    1. Gaji Pokok
                                </td>
                                <td>
                                    Rp {{ number_format($item->gaji_pokok, 0, '', '.') }}
                                </td>
                            @elseif ($i == 1)
                                <td>
                                    2. Tunjangan Jabatan
                                </td>
                                <td>
                                    Rp {{ number_format($item->tunjangan_jabatan, 0, '', '.') }}
                                </td>
                            @else
                                <td>
                                    @if (isset($totalTunjangan[$i - 2]))
                                        {{ $i + 1 }}. Tunjangan {{ $totalTunjangan[$i - 2]['nama_tunjangan'] }}
                                        @if (!empty($totalTunjangan[$i - 2]['note_tunjangan']))
                                            <br> ({{ $totalTunjangan[$i - 2]['note_tunjangan'] }})
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if (isset($totalTunjangan[$i - 2]))
                                        Rp {{ number_format($totalTunjangan[$i - 2]['nilai_tunjangan'], 0, '', '.') }}
                                    @endif
                                </td>
                            @endif

                            <td>
                                @if (isset($totalPotongan[$i]))
                                    {{ $i + 1 }}. {{ $totalPotongan[$i]['nama_potongan'] }}
                                    @if (!empty($totalPotongan[$i]['note_potongan']))
                                        <br> ({{ $totalPotongan[$i]['note_potongan'] }})
                                    @endif
                                @endif
                            </td>
                            <td>
                                @if (isset($totalPotongan[$i]))
                                    Rp {{ number_format($totalPotongan[$i]['nilai_potongan'], 0, '', '.') }}
                                @endif
                            </td>
                        </tr>
                    @endfor
                    <tr>
                        <td colspan="4">&nbsp;</td>
                    </tr>
                    @php
                        $total_tunjangan =
                            $item->gaji_pokok +
                            $item->tunjangan_jabatan +
                            array_sum(array_column($totalTunjangan, 'nilai_tunjangan'));
                        $total_potongan = array_sum(array_column($totalPotongan, 'nilai_potongan'));
                    @endphp
                    <tr>
                        <td class="highlightJumlah" colspan="2">
                            <strong>Jumlah Gaji Bruto</strong>
                            <div class="align-right currency">
                                <strong>Rp</strong>
                                <strong>{{ number_format($total_tunjangan, 0, '', '.') }}</strong>
                            </div>
                        </td>
                        <td class="highlightJumlah" colspan="2">
                            <strong>Jumlah Potongan</strong>
                            <div class="align-right currency">
                                <strong>Rp</strong>
                                <strong>{{ number_format($total_potongan, 0, '', '.') }}</strong>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="highlight" colspan="2">
                            <strong>Jumlah Take Home Pay</strong>
                            <div class="align-right currency">
                                <strong>Rp</strong>
                                <strong>{{ number_format($total_tunjangan - $total_potongan, 0, '', '.') }}</strong>
                            </div>
                        </td>
                        <td class="highlight" colspan="2"></td>
                    </tr>
                </tbody>
            </table>

            <table width="100%" style="border: none;">
                <tr class="footer">
                    <td style="border: none; text-align: left;">
                        <p>Semarang, {{ $tanggalCetak }} </p>
                        <p>Dibuat Oleh :</p>
                        <br>
                        <br>
                        <p class="font-weight-bold">Finance</p>
                    </td>
                    <td width="150px" style="border: none;">
                        <p>&nbsp;</p>
                        <p>Diterima Oleh:</p>
                        <br>
                        <br>
                        <p class="font-weight-bold">{{ $item->nama }}</p>
                    </td>
                </tr>
            </table>
        @endif
    @endforeach

</body>

</html>
