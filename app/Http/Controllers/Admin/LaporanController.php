<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\PotonganGaji;
use App\Models\Sdm;
use Illuminate\Support\Facades\Response;
use PDF;


class LaporanController extends Controller
{
    public function index()
    {
        $sdms = Sdm::orderBy('nama', 'asc')
            ->get(['nama', 'id']);

        return view('admin.laporan.index', compact('sdms'));
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

    // Cetak PDF Karyawan
    public function store(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $namaBulan = $this->konversiBulan($bulan);
        $tanggal = $bulan . $tahun;
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
            ->where('absensi.sdm_id', $request->karyawan_id)
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

    public function cetakPinjaman($id)
    {

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
            // Handle the case when the item is not found
            // Redirect or display an error message
        }
    }

    public function urlPrintPDF(Request $request, $chat_id, $bulan, $tahun)
    {
        $namaBulan = $this->konversiBulan($bulan);
        $tanggal = $bulan . $tahun;

        // Ambil data absensi termasuk chat_id
        $items = DB::table('absensi')
            ->select(
                'sdm_id',
                'bulan',
                'nama',
                'email',
                'nik',
                'jenis_kelamin',
                'entitas',
                'divisi',
                'jabatan',
                'tunjangan_jabatan',
                'tunjangan',
                'potongan',
                'chat_id'
            )
            ->where('bulan', $tanggal)
            ->where('chat_id', $chat_id)
            ->get();

        // Pastikan data ditemukan
        if ($items->isNotEmpty()) {
            // Generate URL untuk endpoint print PDF
            $pdfEndpoint = route('url-pdf', [
                'chat_id' => $chat_id,
                'bulan' => $bulan,
                'tahun' => $tahun,
            ]);

            // Ubah nama rute di dalam pesan JSON
            $response = [
                'status' => 'success',
                'message' => 'Slip Gaji ditemukan',
                'pdf_link' => str_replace('/link-pdf', '/print-pdf', $pdfEndpoint),
            ];

            return response()->json($response, 200);
        } else {
            // Handle the case when there is no data found
            return response()->json([
                'status' => false,
                'message' => 'Slip Gaji yang diminta belum tersedia',
            ], 404);
        }
    }


    public function printPDF(Request $request, $chat_id, $bulan, $tahun)
    {
        $namaBulan = $this->konversiBulan($bulan);
        $tanggal = $bulan . $tahun;

        // Ambil data absensi termasuk chat_id
        $items = DB::table('absensi')
            ->select(
                'sdm_id',
                'bulan',
                'nama',
                'email',
                'nik',
                'jenis_kelamin',
                'entitas',
                'divisi',
                'jabatan',
                'tunjangan_jabatan',
                'tunjangan',
                'potongan',
                'chat_id'
            )
            ->where('bulan', $tanggal)
            ->where('chat_id', $chat_id)
            ->get();

        // Pastikan data ditemukan
        if ($items->isNotEmpty()) {
            $item = $items->first(); // Mengambil hanya satu baris karena asumsi Anda hanya ingin satu item
            $timestamp = time();


            // Generate PDF menggunakan DomPDF
            $pdf = PDF::loadView('admin.laporan.cetak-gaji', compact('items', 'bulan', 'namaBulan', 'tahun'));
            $pdf->setEncryption($timestamp, '', ['print', 'copy'], 0);
            $pdfContent = $pdf->output();

            // Response PDF langsung sebagai file download
            $response = Response::make($pdfContent, 200);
            $response->header('Content-Type', 'application/pdf');
            $response->header('Content-Disposition', 'attachment; filename=Slip_' . $item->entitas . '_' . $item->nama . '_' . $timestamp . '.pdf');
            $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
            $response->header('Cache-Control', 'post-check=0, pre-check=0');
            $response->header('Pragma', 'no-cache');

            return $response;
        } else {
            // Handle the case when there is no data found
            return response()->json([
                'status' => false,
                'message' => 'Slip Gaji yang diminta belum tersedia',
            ], 404);
        }
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
            ->where('absensi.sdm_id', $request->karyawan_id)
            ->get();

        return view('admin.laporan.cetak-gaji-karyawan', compact('bulan', 'tahun', 'items'));
    }
}
