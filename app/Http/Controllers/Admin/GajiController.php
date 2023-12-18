<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\KomponenGaji;
use App\Models\PotonganGaji;
use App\Models\Sdm;
use PDF;

class GajiController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->get('bulan') . $request->get('tahun');
        if ($bulan === '') {
            $bulanSaatIni = ltrim(date('m') . date('Y'), '0');
            $items = DB::table('absensi')
                ->select('absensi.id',  'absensi.sdm_id', 'absensi.bulan', 'absensi.nama', 'absensi.nik', 'absensi.jenis_kelamin', 'absensi.entitas', 'absensi.divisi', 'absensi.jabatan', 'absensi.tunjangan_jabatan', 'absensi.tunjangan', 'absensi.potongan')
                ->where('absensi.bulan', $bulanSaatIni)
                ->get();
        } else {
            $items = DB::table('absensi')
                ->select('absensi.id', 'absensi.sdm_id', 'absensi.bulan', 'absensi.nama', 'absensi.nik', 'absensi.jenis_kelamin', 'absensi.entitas', 'absensi.divisi', 'absensi.jabatan', 'absensi.tunjangan_jabatan', 'absensi.tunjangan', 'absensi.potongan')
                ->where('absensi.bulan', $bulan)

                ->get();
        }

        return view('admin.gaji.index', compact('items'));
    }

    public function gajiSerentak(Request $request, $bulan, $tahun)
    {
        // Validasi jika diperlukan

        // Ambil data SDM
        $sdms = Sdm::all();

        // Lakukan proses gaji serentak
        foreach ($sdms as $sdm) {
            // Panggil fungsi untuk menyimpan data ke Absensi
            $this->storeGajiSerentak($sdm, $bulan, $tahun);
        }

        return redirect()->route('admin.gaji.index', [
            'bulan' => $bulan,
            'tahun' => $tahun,
        ])->with([
            'success' => 'Gaji serentak bulan ini berhasil disimpan',
            'alert-info' => 'info',
        ]);
    }



    // Fungsi untuk menyimpan data ke Absensi
    private function storeGajiSerentak($sdm, $bulan, $tahun)
    {
        // Mendapatkan data komponen gaji untuk pengguna (sdm) saat ini
        $komponenGaji = KomponenGaji::where('sdm_id', $sdm->id)->get();

        // Mendapatkan data potongan gaji untuk pengguna (sdm) saat ini
        $potonganGaji = PotonganGaji::where('sdm_id', $sdm->id)->get();

        // Menyusun data tunjangan dalam format JSON
        $tunjanganDinamis = [];
        if ($komponenGaji->isNotEmpty()) {
            $tunjanganDinamis = $komponenGaji->toArray();
        }

        // Menyusun data potongan dalam format JSON
        $potonganDinamis = [];
        if ($potonganGaji->isNotEmpty()) {
            $potonganDinamis = $potonganGaji->toArray();
        }

        // Ambil data Gaji terkait
        // Sesuaikan dengan struktur database dan kebutuhan Anda
        $gaji = [
            'sdm_id' => $sdm->id,
            'chat_id' => $sdm->chat_id,
            'bulan' => $bulan . $tahun,
            'nama' => $sdm->nama,
            'nik' => $sdm->nik,
            'jenis_kelamin' => $sdm->jenis_kelamin,
            'jabatan' => $sdm->jabatan->nama,
            'tunjangan_jabatan' => $sdm->jabatan->tunjangan_jabatan,
            'tunjangan' => json_encode($tunjanganDinamis),
            'potongan' => json_encode($potonganDinamis),
            'entitas' => $sdm->entitas->nama,
            'divisi' => $sdm->divisi->nama,
        ];

        // Simpan data ke Absensi
        Absensi::create($gaji);
    }


    public function show(string $id)
    {
        $title = "Detail Gaji SDM";
        $pages = "Data Gaji";

        $data = Absensi::findOrFail($id);

        // Extracting year and month from the field
        $bulanNumeric = substr($data->bulan, 0, -4);  // Get the digits before the last 4
        $tahun = substr($data->bulan, -4);  // Get the last 4 digits

        // Convert numeric month to its name
        $bulan = $this->konversiBulan($bulanNumeric);

        return view('admin.gaji.show', compact('title', 'pages', 'data', 'bulan', 'tahun'));
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
        // Your existing code to fetch data from the database
        $namaBulan = $this->konversiBulan($bulan);
        $tanggal = $bulan . $tahun;
        $items = DB::table('absensi')
            ->select(
                'absensi.sdm_id',
                'absensi.bulan',
                'absensi.nama',
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
            ->get();

        // Generate PDF using DomPDF
        $pdf = PDF::loadView('admin.gaji.cetak', compact('items', 'bulan', 'namaBulan', 'tahun'));

        // You can customize the filename if needed
        $filename = 'Data Gaji SDM_' . $namaBulan . '_' . $tahun . '.pdf';

        // Use download() to send the PDF as a download to the user
        return $pdf->download($filename);
    }

    public function destroy($id)
    {
        $gaji = Absensi::findOrFail($id);

        $gaji->delete();

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data SDM ' . $gaji->nama . ' Berhasil Diundo!.',
        ]);
    }
}
