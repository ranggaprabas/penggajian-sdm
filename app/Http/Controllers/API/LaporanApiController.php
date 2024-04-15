<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;


class LaporanApiController extends Controller
{

    public function konversiBulan($bulan)
    {
        $daftarBulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        return $daftarBulan[$bulan] ?? '';
    }
    // Cetak PDF Karyawan
    public function store(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $namaBulan = $this->konversiBulan($bulan);
        $tanggal = $bulan . $tahun;
        $sdmId = Auth::user()->id;
        $items = DB::table('absensi')
            ->select(
                'absensi.sdm_id',
                'absensi.bulan',
                'absensi.nama',
                'absensi.email',
                'absensi.nik',
                'absensi.jenis_kelamin',
                'absensi.entitas',
                'absensi.divisi',
                'absensi.jabatan',
                'absensi.tunjangan_jabatan',
                'absensi.tunjangan',
                'absensi.potongan',
            )
            ->where('absensi.bulan', $tanggal)
            ->where('absensi.sdm_id', $sdmId)
            ->get();

        // Ensure there is at least one item
        if ($items->isNotEmpty()) {
            $item = $items->first(); // Mengasumsikan Anda ingin item pertama

            // Generate timestamp
            $timestamp = time();

            // Generate PDF menggunakan DomPDF
            $pdf = PDF::loadView('admin.laporan.cetak-gaji', compact('items', 'bulan', 'namaBulan', 'tahun'));

            // Anda dapat menyesuaikan nama file dengan nama karyawan, bulan, tahun, dan timestamp
            $filename = 'Slip_' . $item->entitas . '_' . $item->nama . '_' . $timestamp . '.pdf';

            // Set password pengguna (timestamp) untuk PDF
            $pdf->setEncryption($timestamp, '', ['print', 'copy'], 0);

            // Gunakan download() untuk mengirimkan PDF sebagai unduhan ke pengguna
            return $pdf->download($filename);
        } else {
            // Handle the case when there is no data found
            return response()->json([
                'status' => false,
                'message' => 'Slip Gaji yang diminta belum tersedia',
            ], 404);
        }
    }
}
