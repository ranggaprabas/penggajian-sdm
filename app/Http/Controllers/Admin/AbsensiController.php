<?php

namespace App\Http\Controllers\Admin;

use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\KomponenGaji;
use App\Models\PotonganGaji;
use App\Models\Sdm;
use App\Models\User;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->get('bulan') . $request->get('tahun');

        if ($bulan === '') {
            $bulanSaatIni = ltrim(date('m') . date('Y'), '0');
            $absensis = Absensi::with('user')->where('bulan', $bulanSaatIni)->whereHas('user', function ($query) {
                $query->where('is_admin', '!=', 1); // Menambahkan kondisi ini untuk menghindari user dengan is_admin = 1
            })->get();
        } else {
            $absensis = Absensi::with('user')->where('bulan', $bulan)->whereHas('user', function ($query) {
                $query->where('is_admin', '!=', 1); // Menambahkan kondisi ini untuk menghindari user dengan is_admin = 1
            })->get();
        }

        return view('admin.absensis.index', compact('absensis'));
    }

    public function show(Request $request)
    {
        $bulan = $request->get('bulan') . $request->get('tahun');

        if ($bulan === '') {
            $bulanSaatIni = ltrim(date('m') . date('Y'), '0');
            $absensis = DB::table('sdms')
                ->select('sdms.*', 'jabatan.nama as nama_jabatan', 'entitas.nama as nama_entitas', 'divisis.nama as nama_divisi')
                ->join('jabatan', 'sdms.jabatan_id', '=', 'jabatan.id')
                ->join('entitas', 'sdms.entitas_id', '=', 'entitas.id')
                ->join('divisis', 'sdms.divisi_id', '=', 'divisis.id')
                ->whereNotExists(function ($query) use ($bulanSaatIni) {
                    $query->select(DB::raw(1))
                        ->from('absensi')
                        ->whereRaw('sdms.id = absensi.sdm_id')
                        ->where('bulan', $bulanSaatIni);
                })
                ->where('sdms.deleted', '!=', 1)
                ->where('jabatan.deleted', '!=', 1)
                ->get();
        } else {
            $absensis = DB::table('sdms')
                ->select('sdms.*', 'jabatan.nama as nama_jabatan', 'entitas.nama as nama_entitas', 'divisis.nama as nama_divisi')
                ->join('jabatan', 'sdms.jabatan_id', '=', 'jabatan.id')
                ->join('entitas', 'sdms.entitas_id', '=', 'entitas.id')
                ->join('divisis', 'sdms.divisi_id', '=', 'divisis.id')
                ->whereNotExists(function ($query) use ($bulan) {
                    $query->select(DB::raw(1))
                        ->from('absensi')
                        ->whereRaw('sdms.id = absensi.sdm_id')
                        ->where('bulan', $bulan);
                })
                ->where('sdms.deleted', '!=', 1)
                ->where('jabatan.deleted', '!=', 1)
                ->get();
        }

        return view('admin.absensis.show', compact('absensis'));
    }


    public function store(Request $request)
    {

        // Check if individual_submit button is clicked
        if ($request->has('individual_submit')) {
            $sdm_id = $request->input('individual_submit');

            // Rest of your existing logic for individual gaji
            $sdm = Sdm::findOrFail($sdm_id);

            // Mendapatkan data komponen gaji untuk pengguna (sdm) saat ini
            $komponenGaji = KomponenGaji::where('sdm_id', $sdm->id)->get();

            // Mendapatkan data potongan gaji untuk pengguna (sdm) saat ini
            $potonganGaji = PotonganGaji::where('sdm_id', $sdm->id)->get();

            // komponen gaji ditemukan
            if ($komponenGaji) {
                // Menyusun data absensi beserta data komponen gaji (tunjangan) dalam format JSON
                $tunjanganDinamis = $komponenGaji->toArray();

                // Potongan gaji ditemukan
                if ($potonganGaji) {
                    // Menyusun data potongan gaji dalam format JSON
                    $potonganDinamis = $potonganGaji->toArray();
                } else {
                    // Jika tidak ada potongan gaji, set data potongan menjadi array kosong
                    $potonganDinamis = [];
                }


                $dataAbsensi = [
                    'sdm_id' => $sdm->id,
                    'chat_id' => $sdm->chat_id,
                    'bulan' => $request->bulan,
                    'nama' => $sdm->nama,
                    'nik' => $sdm->nik,
                    'jenis_kelamin' => $sdm->jenis_kelamin,
                    'jabatan' => $sdm->jabatan->nama,
                    'tunjangan_jabatan' => $sdm->jabatan->tunjangan_jabatan,
                    'tunjangan' => json_encode($tunjanganDinamis),
                    'potongan' => json_encode($potonganDinamis),
                    'entitas' => $sdm->entitas->nama,
                    'divisi' => $sdm->divisi->nama,
                    // Sisipkan kolom lain yang diperlukan
                ];

                // Simpan data absensi ke dalam tabel
                Absensi::create($dataAbsensi);
            }

            // Additional logic for individual gaji if needed

            return redirect()->back()->with([
                'success' => 'Gaji SDM ' . $sdm->nama . ' berhasil dilakukan',
                'alert-info' => 'info'
            ]);
        }

        foreach ($request->karyawan_id as $sdm_id) {
            // Mendapatkan semua informasi yang Anda butuhkan dari tabel sdms
            $sdm = Sdm::findOrFail($sdm_id);

            // Mendapatkan data komponen gaji untuk pengguna (sdm) saat ini
            $komponenGaji = KomponenGaji::where('sdm_id', $sdm->id)->get();

            // Mendapatkan data potongan gaji untuk pengguna (sdm) saat ini
            $potonganGaji = PotonganGaji::where('sdm_id', $sdm->id)->get();

            // komponen gaji ditemukan
            if ($komponenGaji) {
                // Menyusun data absensi beserta data komponen gaji (tunjangan) dalam format JSON
                $tunjanganDinamis = $komponenGaji->toArray();

                // Potongan gaji ditemukan
                if ($potonganGaji) {
                    // Menyusun data potongan gaji dalam format JSON
                    $potonganDinamis = $potonganGaji->toArray();
                } else {
                    // Jika tidak ada potongan gaji, set data potongan menjadi array kosong
                    $potonganDinamis = [];
                }


                $dataAbsensi = [
                    'sdm_id' => $sdm->id,
                    'chat_id' => $sdm->chat_id,
                    'bulan' => $request->bulan,
                    'nama' => $sdm->nama,
                    'nik' => $sdm->nik,
                    'jenis_kelamin' => $sdm->jenis_kelamin,
                    'jabatan' => $sdm->jabatan->nama,
                    'tunjangan_jabatan' => $sdm->jabatan->tunjangan_jabatan,
                    'tunjangan' => json_encode($tunjanganDinamis),
                    'potongan' => json_encode($potonganDinamis),
                    'entitas' => $sdm->entitas->nama,
                    'divisi' => $sdm->divisi->nama,
                    // Sisipkan kolom lain yang diperlukan
                ];

                // Simpan data absensi ke dalam tabel
                Absensi::create($dataAbsensi);
            }
        }
        return redirect()->back()->with([
            'success' => 'Gaji serentak berhasil dilakukan',
            'alert-info' => 'info'
        ]);
    }
}
