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
    public function getPdf(Request $request)
    {
        $bulan = $request->query('bulan');
        $tahun = $request->query('tahun');
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
                'absensi.gaji_pokok',
                'absensi.potongan'
            )
            ->where('absensi.bulan', $tanggal)
            ->where('absensi.sdm_id', $sdmId)
            ->get();

        if ($items->isNotEmpty()) {
            $item = $items->first();

            $timestamp = time();

            $pdf = PDF::loadView('admin.laporan.cetak-gaji', compact('items', 'bulan', 'namaBulan', 'tahun'));

            $filename = 'Slip_' . $item->entitas . '_' . $item->nama . '_' . $timestamp . '.pdf';

            $pdf->setEncryption($timestamp, '', ['print', 'copy'], 0);

            return $pdf->download($filename);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Slip Gaji yang diminta belum tersedia',
            ], 404);
        }
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
                'absensi.gaji_pokok',
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


    public function cetakPinjamanApi($id)
    {

        // Mendapatkan sdm_id pengguna yang sedang login
        $sdmId = Auth::user()->id;

        $item = DB::table('pinjaman')
            ->select(
                'pinjaman.sdm_id',
                'pinjaman.nama',
                'pinjaman.nik',
                'pinjaman.entitas',
                'pinjaman.divisi',
                'pinjaman.jabatan',
                'pinjaman.nilai_pinjaman',
                'pinjaman.keterangan',
                'pinjaman.status',
            )
            ->where('pinjaman.id', $id)
            ->where('pinjaman.sdm_id', $sdmId)
            ->first();

        // Pastikan item ditemukan
        if ($item) {


            $items = [$item];

            // Generate PDF menggunakan DomPDF
            $pdf = PDF::loadView('admin.pinjaman.cetak-pinjaman', compact('items')); // Tambahkan 'namaBulan' dan 'tahun'

            // Anda dapat menyesuaikan nama file dengan nama karyawan, bulan, tahun, dan timestamp
            $filename = 'Pinjaman_' . $item->entitas . '_' . $item->nama . '.pdf';

            // Gunakan download() untuk mengirimkan PDF sebagai unduhan ke pengguna
            return $pdf->download($filename);
        } else {
            // Handle the case when there is no data found
            return response()->json([
                'status' => false,
                'message' => 'Pinjaman tidak ditemukan',
            ], 404);
        }
    }
}
