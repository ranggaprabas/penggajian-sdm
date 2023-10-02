<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\PotonganGaji;

class GajiController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->get('bulan') . $request->get('tahun');
        if ($bulan === '') {
            $bulanSaatIni = ltrim(date('m') . date('Y'), '0');
            $items = DB::table('absensi')
                ->select('absensi.user_id', 'absensi.bulan', 'absensi.nama', 'absensi.nik', 'absensi.jenis_kelamin', 'jabatan.nama as nama_jabatan', 'jabatan.gaji_pokok', 'jabatan.transportasi', 'jabatan.uang_makan', 'entitas.nama as nama_entitas')
                ->join('jabatan', 'jabatan.id', '=', 'absensi.jabatan') // Sesuaikan nama kolomnya
                ->leftJoin('entitas', 'entitas.id', '=', 'absensi.entitas') // Sesuaikan nama kolomnya
                ->where('absensi.bulan', $bulanSaatIni)
                ->get();
        } else {
            $items = DB::table('absensi')
                ->select('absensi.user_id', 'absensi.bulan', 'absensi.nama', 'absensi.nik', 'absensi.jenis_kelamin', 'jabatan.nama as nama_jabatan', 'jabatan.gaji_pokok', 'jabatan.transportasi', 'jabatan.uang_makan', 'entitas.nama as nama_entitas')
                ->join('jabatan', 'jabatan.id', '=', 'absensi.jabatan') // Sesuaikan nama kolomnya
                ->leftJoin('entitas', 'entitas.id', '=', 'absensi.entitas') // Sesuaikan nama kolomnya
                ->where('absensi.bulan', $bulan)

                ->get();
        }

        return view('admin.gaji.index', compact('items'));
    }



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

    public function cetak($bulan, $tahun)
    {
        // Menggunakan fungsi konversiBulan untuk mengonversi angka bulan menjadi teks bulan
        $namaBulan = $this->konversiBulan($bulan);

        $tanggal = $bulan . $tahun;
        $items = DB::table('absensi')
        ->select(
            'absensi.user_id',
            'absensi.bulan',
            'absensi.nama',
            'absensi.nik',
            'absensi.jenis_kelamin',
            'jabatan.nama as nama_jabatan',
            'jabatan.gaji_pokok',
            'jabatan.transportasi',
            'jabatan.uang_makan',
            'entitas.nama as nama_entitas'
        )
        ->join('jabatan', 'jabatan.id', '=', 'absensi.jabatan')
        ->leftJoin('entitas', 'entitas.id', '=', 'absensi.entitas')
        ->where('absensi.bulan', $tanggal)
        ->get();

        return view('admin.gaji.cetak', compact('items', 'bulan', 'namaBulan', 'tahun'));
    }
}
