<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\PotonganGaji;

class LaporanController extends Controller
{
    public function index()
    {
        // Ambil semua pengguna yang bukan admin (is_admin != 1) dan urutkan berdasarkan nama
        $users = User::where('is_admin', '!=', 1)
            ->orderBy('nama', 'asc')
            ->get(['nama', 'id']);

        return view('admin.laporan.index', compact('users'));
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

    public function store(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $namaBulan = $this->konversiBulan($bulan);
        $tanggal = $bulan . $tahun;
        $items = DB::table('absensi')
            ->select(
                'absensi.user_id',
                'absensi.bulan',
                'absensi.nama',
                'absensi.nik',
                'absensi.jenis_kelamin',
                'absensi.entitas',
                'absensi.jabatan',
                'absensi.tunjangan_jabatan',
                'absensi.tunjangan',
                'absensi.potongan',
            )
            ->where('absensi.bulan', $tanggal)
            ->where('absensi.user_id', $request->karyawan_id)
            ->get();

        return view('admin.laporan.cetak-gaji', compact('bulan', 'namaBulan', 'tahun', 'items'));
    }


    public function show()
    {
        return view('admin.laporan.show');
    }

    public function cekGaji(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $tanggal = $bulan . $tahun;
        $karyawan_id = auth()->id();
        $items = DB::table('absensi')
            ->select(
                'absensi.user_id',
                'absensi.bulan',
                'absensi.nama',
                'absensi.nik',
                'absensi.jenis_kelamin',
                'absensi.entitas',
                'absensi.jabatan',
                'absensi.tunjangan_jabatan',
                'absensi.tunjangan',
                'absensi.potongan',
            )
            ->where('absensi.bulan', $tanggal)
            ->where('absensi.user_id', $request->karyawan_id)
            ->get();

        return view('admin.laporan.cetak-gaji-karyawan', compact('bulan', 'tahun', 'items'));
    }
}
