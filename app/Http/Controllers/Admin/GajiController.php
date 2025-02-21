<?php

namespace App\Http\Controllers\Admin;

use App\Exports\GajiExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Imports\GajiImport;
use App\Models\Absensi;
use App\Models\Divisi;
use App\Models\Entitas;
use App\Models\Jabatan;
use App\Models\KomponenGaji;
use App\Models\PotonganGaji;
use App\Models\Sdm;
use App\Models\TelegramUser;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Response;
use PDF;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Validators\ValidationException as ExcelValidationException;


class GajiController extends Controller
{
    public function index(Request $request)
    {
        // Set nilai default untuk bulan dan tahun saat ini
        $bulan = $request->get('bulan', date('n')) . $request->get('tahun', date('Y'));

        // Mendapatkan entitas_id admin yang sedang login
        $entitasAdmin = Auth::user()->entitas->nama;
        $statusAdmin = Auth::user()->status;

        // Hitung jumlah SDM yang belum masuk gaji berdasarkan field bulan dari tabel absensi
        $sdmCountNotInAbsensi = 0;

        // Jika status pengguna adalah 1 (atau sesuai dengan kondisi Anda), hitung jumlah SDM yang belum masuk gaji
        if ($statusAdmin == 1) {
            $sdmCountNotInAbsensi = Sdm::whereDoesntHave('absensi', function ($query) use ($bulan) {
                $query->where('bulan', $bulan);
            })
                ->where('deleted', '!=', 1)
                ->whereHas('jabatan', function ($query) {
                    $query->where('deleted', '!=', 1);
                })
                ->count();
        } else {
            // Jika status bukan 1, hitung jumlah SDM yang ada di tabel sdm namun belum diabsen
            $sdmCountNotInAbsensi = Sdm::whereDoesntHave('absensi', function ($query) use ($bulan, $entitasAdmin) {
                $query->where('bulan', $bulan)
                    ->where('entitas', $entitasAdmin);
            })
                ->where('entitas_id', Auth::user()->entitas->id) // Sesuaikan dengan field yang sesuai di tabel sdm
                ->where('deleted', '!=', 1)
                ->whereHas('jabatan', function ($query) {
                    $query->where('deleted', '!=', 1);
                })
                ->count();
        }

        // Mendapatkan data gaji berdasarkan bulan dan entitas_id
        if ($statusAdmin == 1) {
            // Jika status adalah 1, tampilkan semua data
            $items = DB::table('absensi')
                ->select('absensi.id', 'absensi.sdm_id', 'absensi.bulan', 'absensi.nama', 'absensi.email', 'absensi.nik', 'absensi.jenis_kelamin', 'absensi.entitas', 'absensi.divisi', 'absensi.jabatan', 'absensi.tunjangan_jabatan', 'absensi.gaji_pokok', 'absensi.tunjangan', 'absensi.potongan')
                ->where('absensi.bulan', $bulan)
                ->get();
        } else {
            // Jika status bukan 1, tampilkan data sesuai entitas_id
            $items = DB::table('absensi')
                ->select('absensi.id', 'absensi.sdm_id', 'absensi.bulan', 'absensi.nama', 'absensi.email', 'absensi.nik', 'absensi.jenis_kelamin', 'absensi.entitas', 'absensi.divisi', 'absensi.jabatan', 'absensi.tunjangan_jabatan', 'absensi.gaji_pokok', 'absensi.tunjangan', 'absensi.potongan')
                ->where('absensi.bulan', $bulan)
                ->where('absensi.entitas', $entitasAdmin)
                ->get();
        }

        return view('admin.gaji.index', compact('items', 'sdmCountNotInAbsensi'));
    }


    public function gajiSerentak(Request $request, $bulan, $tahun)
    {
        // Validasi jika diperlukan

        // Mendapatkan entitas_id admin yang sedang login
        $entitasAdmin = Auth::user()->entitas->id;
        $statusAdmin = Auth::user()->status;

        // Ambil data SDM sesuai dengan entitas yang sedang login
        $sdms = ($statusAdmin == 1) ? Sdm::all() : Sdm::where('entitas_id', $entitasAdmin)->get();

        // Inisialisasi array untuk menyimpan informasi SDM yang baru dimasukkan ke Absensi
        $sdmsInserted = [];

        // Lakukan proses gaji serentak
        foreach ($sdms as $sdm) {
            // Panggil fungsi untuk menyimpan data ke Absensi
            $result = $this->storeGajiSerentak($sdm, $bulan, $tahun);

            // Tandai SDM yang baru dimasukkan
            if ($result) {
                $sdmsInserted[] = $sdm->nama;
            }
        }

        // Berikan keterangan bahwa gaji serentak berhasil dilakukan
        $keterangan = 'Gaji serentak bulan ini sudah berhasil disimpan';

        // Berikan keterangan jika ada SDM yang baru dimasukkan
        if (!empty($sdmsInserted)) {
            $keterangan = 'Gaji serentak bulan ini berhasil disimpan, data SDM baru berhasil dimasukkan';
        }

        return redirect()->route('admin.gaji.index', [
            'bulan' => $bulan,
            'tahun' => $tahun,
        ])->with([
            'success' => $keterangan,
            'alert-info' => 'info',
        ]);
    }


    private function storeGajiSerentak($sdm, $bulan, $tahun)
    {
        // Check if the employee has been marked as deleted
        if ($sdm->deleted == 1) {
            // If deleted, skip processing for this employee
            return false;
        }

        if ($sdm->jabatan->deleted == 1) {
            return false;
        }

        // Mendapatkan data komponen gaji untuk pengguna (sdm) saat ini
        $komponenGaji = KomponenGaji::where('sdm_id', $sdm->id)->get();

        // Menyusun data tunjangan dalam format JSON
        $tunjanganDinamis = [];
        foreach ($komponenGaji as $item) {
            $tunjanganDinamis[] = [
                'id' => $item->id,
                'sdm_id' => $item->sdm_id,
                'nama_tunjangan' => $item->nama_tunjangan,
                'nilai_tunjangan' => $item->nilai_tunjangan,
                'note_tunjangan' => $item->note_tunjangan,
            ];
        }

        // Mendapatkan data potongan gaji untuk pengguna (sdm) saat ini
        $potonganGaji = PotonganGaji::where('sdm_id', $sdm->id)->get();

        // Menyusun data potongan dalam format JSON
        $potonganDinamis = [];
        foreach ($potonganGaji as $item) {
            $potonganDinamis[] = [
                'id' => $item->id,
                'sdm_id' => $item->sdm_id,
                'nama_potongan' => $item->nama_potongan,
                'nilai_potongan' => $item->nilai_potongan,
                'note_potongan' => $item->note_potongan,
            ];
        }

        // Ambil data Gaji terkait
        // Sesuaikan dengan struktur database dan kebutuhan Anda
        $gaji = [
            'sdm_id' => $sdm->id,
            'chat_id' => $sdm->chat_id,
            'bulan' => $bulan . $tahun,
            'nama' => $sdm->nama,
            'email' => $sdm->email,
            'nik' => $sdm->nik,
            'status' => $sdm->status,
            'jenis_kelamin' => $sdm->jenis_kelamin,
            'jabatan' => $sdm->jabatan->nama,
            'tunjangan_jabatan' => $sdm->jabatan->tunjangan_jabatan,
            'gaji_pokok' => $sdm->gaji_pokok,
            'tunjangan' => json_encode($tunjanganDinamis),
            'potongan' => json_encode($potonganDinamis),
            'entitas' => $sdm->entitas->nama,
            'divisi' => $sdm->divisi->nama,
        ];

        // Cek apakah data SDM sudah ada di dalam tabel Absensi
        $isSdmInAbsensi = Absensi::where('sdm_id', $sdm->id)
            ->where('bulan', $bulan . $tahun)
            ->exists();

        // Jika SDM belum ada di dalam Absensi, simpan data
        if (!$isSdmInAbsensi) {
            Absensi::create($gaji);
            return true; // Berhasil disimpan
        }

        return false; // SDM sudah ada di dalam Absensi
    }

    public function cetakPDF($id, $bulan, $tahun)
    {

        $tanggal = $bulan . $tahun;

        $item = DB::table('absensi')
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
            ->where('absensi.id', $id)
            ->where('absensi.bulan', $tanggal)

            ->first();

        // Pastikan item ditemukan
        if ($item) {

            $namaBulan = $this->konversiBulan($bulan);

            $items = [$item];

            // Generate timestamp
            $timestamp = time();

            // Generate PDF menggunakan DomPDF
            $pdf = PDF::loadView('admin.laporan.cetak-gaji', compact('items', 'namaBulan', 'tahun')); // Tambahkan 'namaBulan' dan 'tahun'

            // Anda dapat menyesuaikan nama file dengan nama karyawan, bulan, tahun, dan timestamp
            $filename = 'Slip_' . $item->entitas . '_' . $item->nama . '_' . $timestamp . '.pdf';

            // Set password pengguna (timestamp) untuk PDF
            $pdf->setEncryption($timestamp, '', ['print', 'copy'], 0);

            // Gunakan download() untuk mengirimkan PDF sebagai unduhan ke pengguna
            return $pdf->download($filename);
        } else {
            // Handle the case when the item is not found
            // Redirect or display an error message
        }
    }


    public function show(string $id)
    {
        $title = "Detail Payroll SDM";
        $pages = "Payroll SDM";

        $data = Absensi::findOrFail($id);

        // Extracting year and month from the field
        $bulanNumeric = substr($data->bulan, 0, -4);  // Get the digits before the last 4
        $tahun = substr($data->bulan, -4);  // Get the last 4 digits

        // Convert numeric month to its name
        $bulan = $this->konversiBulan($bulanNumeric);

        $user = Auth::user();
        if ($user->status != 1 && $user->entitas->nama != $data->entitas) {
            abort(404, 'Unauthorized');
        }


        return view('admin.gaji.show', compact('title', 'pages', 'data', 'bulan', 'tahun'));
    }

    public function edit($id)
    {
        $divisis = Divisi::get(['id', 'nama']);
        $jabatans = Jabatan::get(['id', 'nama', 'tunjangan_jabatan', 'deleted']);
        $telegramUsers = TelegramUser::get(['id', 'chat_id', 'username']);

        $user = Auth::user();
        $entityId = $user->entitas_id;

        if ($user->status == 1) {
            $jabatans = Jabatan::get(['id', 'nama', 'tunjangan_jabatan', 'deleted']);
            $divisis = Divisi::get(['id', 'nama']);
        } else {
            // Tampilkan jabatans sesuai dengan entitas ID pengguna
            $jabatans = Jabatan::where('entitas_id', $entityId)
                ->select('id', 'nama', 'tunjangan_jabatan', 'deleted')
                ->get();
            $divisis = Divisi::where('entitas_id', $entityId)
                ->select('id', 'nama')
                ->get();
        }

        // Jika status pengguna adalah 1, tampilkan semua entitas
        if ($user->status == 1) {
            $entita = Entitas::get(['id', 'nama']);
        } else {
            // Jika status pengguna bukan 1, tampilkan hanya entitas sesuai entitas_id pengguna
            $entita = Entitas::where('id', $user->entitas_id)->get(['id', 'nama']);
        }

        $gaji = Absensi::findOrFail($id);
        // Extracting year and month from the field
        $bulanNumeric = substr($gaji->bulan, 0, -4);  // Get the digits before the last 4
        $tahun = substr($gaji->bulan, -4);  // Get the last 4 digits

        // Convert numeric month to its name
        $bulan = $this->konversiBulan($bulanNumeric);



        // Check if the user's entitas matches the entitas in the gaji data
        if ($user->status != 1 && $user->entitas->nama != $gaji->entitas) {
            abort(404, 'Unauthorized');
        }

        $tunjangans = json_decode($gaji->tunjangan, true);
        $potongans = json_decode($gaji->potongan, true);

        // Mendapatkan semua data Absensi
        $gajiData = Absensi::all();

        // Menyusun opsi tunjangan dan potongan dari semua data Absensi
        $opsiTunjangan = [];
        $opsiPotongan = [];
        foreach ($gajiData as $gajiItem) {
            $tunjanganArray = json_decode($gajiItem->tunjangan, true);
            $potonganArray = json_decode($gajiItem->potongan, true);

            foreach ($tunjanganArray as $item) {
                $opsiTunjangan[$gajiItem->id][$item['nama_tunjangan']] = $item['nama_tunjangan'];
            }

            foreach ($potonganArray as $item) {
                $opsiPotongan[$gajiItem->id][$item['nama_potongan']] = $item['nama_potongan'];
            }
        }

        return view('admin.gaji.edit', compact('entita', 'divisis', 'jabatans', 'telegramUsers', 'gaji', 'tunjangans', 'potongans', 'opsiTunjangan', 'opsiPotongan', 'bulan', 'tahun'));
    }

    public function update(Request $request, $id)
    {
        $gaji = Absensi::findOrFail($id);

        $this->validate($request, [
            'chat_id' => 'required',
            'nama' => 'required',
            'entitas' => 'required',
            'divisi' => 'required',
            'jabatan' => 'required',
            'email' => 'required',
            'jenis_kelamin' => 'required',
            'chat_id' => 'nullable',
            'nik' => 'required',
            'gaji_pokok' => 'required',
        ]);

        // Update data gaji
        $gaji->update($request->all());

        // Update data tunjangan
        $tunjangans = [];
        foreach ($request->input('nama_tunjangan', []) as $key => $nama) {
            $nilai = $request->input('nilai_tunjangan')[$key];
            $noteTunjangan = $request->input('note_tunjangan')[$key] ?? null;

            $tunjangans[] = [
                'nama_tunjangan' => ucwords($nama),
                'nilai_tunjangan' => $nilai,
                'note_tunjangan' => $noteTunjangan,
            ];
        }
        $gaji->tunjangan = json_encode($tunjangans);
        $gaji->save();

        // Update data potongan
        $potongans = [];
        foreach ($request->input('nama_potongan', []) as $key => $nama) {
            $nilai = $request->input('nilai_potongan')[$key];
            $notePotongan = $request->input('note_potongan')[$key] ?? null;

            $potongans[] = [
                'nama_potongan' => ucwords($nama),
                'nilai_potongan' => $nilai,
                'note_potongan' => $notePotongan,
            ];
        }
        $gaji->potongan = json_encode($potongans);
        $gaji->save();

        // Update model Sdm
        $sdm = Sdm::findOrFail($gaji->sdm_id);
        // Update data jabatan dan tunjangan jabatan di tabel Absensi
        $selectedJabatan = Jabatan::findOrFail($request->input('jabatan'));
        $sdm->update([
            'nama' => $request->input('nama'),
            'entitas_id' => Entitas::firstOrCreate(['nama' => $request->input('entitas')])->id,
            'divisi_id' => Divisi::firstOrCreate(['nama' => $request->input('divisi')])->id,
            'jabatan_id' => $selectedJabatan->id,
            'email' => $request->input('email'),
            'nik' => $request->input('nik'),
            'gaji_pokok' => $request->input('gaji_pokok'),
            'jenis_kelamin' => $request->input('jenis_kelamin'),
            'chat_id' => $request->input('chat_id'),
            'status' => $request->input('status'),
            // ... tambahkan kolom-kolom lain yang perlu diupdate
        ]);

        $gaji->jabatan = $selectedJabatan->nama;
        $gaji->tunjangan_jabatan = $selectedJabatan->tunjangan_jabatan;
        $gaji->save();

        // Update juga data tunjangan dan potongan pada model KomponenGaji dan PotonganGaji
        $komponenGaji = $sdm->komponenGaji();
        $potonganGaji = $sdm->potonganGaji();

        // Hapus tunjangan dan potongan lama
        $komponenGaji->delete();
        $potonganGaji->delete();

        // Tambahkan tunjangan baru
        foreach ($tunjangans as $tunjangan) {
            $komponenGaji->create([
                'sdm_id' => $sdm->id,
                'nama_tunjangan' => ucwords($tunjangan['nama_tunjangan']),
                'nilai_tunjangan' => $tunjangan['nilai_tunjangan'],
                'note_tunjangan' => $tunjangan['note_tunjangan'],
            ]);
        }

        // Tambahkan potongan baru
        foreach ($potongans as $potongan) {
            $potonganGaji->create([
                'sdm_id' => $sdm->id,
                'nama_potongan' => ucwords($potongan['nama_potongan']),
                'nilai_potongan' => $potongan['nilai_potongan'],
                'note_potongan' => $potongan['note_potongan'],
            ]);
        }

        $message = 'Data SDM ' . $gaji->nama . ' berhasil diperbarui!';

        return redirect()->route('admin.gaji.index')->with([
            'success' => $message,
            'alert-info' => 'info'
        ]);
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
        $user = Auth::user();
        $entitasAdmin = Auth::user()->entitas->nama;
        // If the user has status 1, fetch data without considering entitas
        if ($user->status == 1) {
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
                    'absensi.gaji_pokok',
                    'absensi.potongan',
                )
                ->where('absensi.bulan', $tanggal)
                ->get();
        } else {
            // If the user doesn't have status 1, fetch data based on their entitas
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
                    'absensi.gaji_pokok',
                    'absensi.potongan',
                )
                ->where('absensi.bulan', $tanggal)
                ->where('absensi.entitas', $entitasAdmin)
                ->get();
        }

        $timestamp = time();

        // Generate PDF using DomPDF
        $pdf = PDF::loadView('admin.gaji.cetak', compact('items', 'bulan', 'namaBulan', 'tahun'));

        // You can customize the filename if needed
        $filename = 'Data Gaji SDM_' . $namaBulan . '_' . $tahun . '_' . $timestamp . '.pdf';

        $pdf->setEncryption($timestamp, '', ['print', 'copy'], 0);

        // Use download() to send the PDF as a download to the user
        return $pdf->download($filename);
    }

    public function exportExcel($bulan, $tahun)
    {
        // Ubah format bulan dan tahun sesuai kebutuhan
        $namaBulan = $this->konversiBulan($bulan);
        $tanggal = $bulan . $tahun;

        $user = Auth::user();
        $entitasAdmin = $user->entitas->nama;

        // Ambil data dari tabel absensi sesuai bulan dan tahun
        if ($user->status == 1) {
            // Jika status adalah 1, tampilkan semua data
            $items = DB::table('absensi')
                ->select(
                    'absensi.id',
                    'absensi.sdm_id',
                    'absensi.chat_id',
                    'absensi.bulan',
                    'absensi.created_at',
                    'absensi.updated_at',
                    'absensi.nama',
                    'absensi.email',
                    'absensi.status',
                    'absensi.nik',
                    'absensi.jenis_kelamin',
                    'absensi.jabatan',
                    'absensi.tunjangan',
                    'absensi.potongan',
                    'absensi.tunjangan_jabatan',
                    'absensi.entitas',
                    'absensi.divisi',
                    'absensi.gaji_pokok',
                )
                ->where('absensi.bulan', $tanggal)
                ->get();
        } else {
            // Jika status bukan 1, tampilkan data sesuai entitas_id
            $items = DB::table('absensi')
                ->select(
                    'absensi.id',
                    'absensi.sdm_id',
                    'absensi.chat_id',
                    'absensi.bulan',
                    'absensi.created_at',
                    'absensi.updated_at',
                    'absensi.nama',
                    'absensi.email',
                    'absensi.status',
                    'absensi.nik',
                    'absensi.jenis_kelamin',
                    'absensi.jabatan',
                    'absensi.tunjangan',
                    'absensi.potongan',
                    'absensi.tunjangan_jabatan',
                    'absensi.entitas',
                    'absensi.divisi',
                    'absensi.gaji_pokok',
                )
                ->where('absensi.bulan', $tanggal)
                ->where('absensi.entitas', $entitasAdmin)
                ->get();
        }

        // Ekspor data ke Excel
        return Excel::download(new GajiExport($items), 'data_gaji.xlsx');
    }

    public function importExcel(Request $request)
    {
        try {
            // Validate the uploaded file
            $request->validate([
                'file' => 'required|mimes:xlsx,xls',
            ]);

            // Get the file from the request
            $file = $request->file('file');

            // Load the first row of the Excel file to check for required keys
            $firstRow = Excel::toArray(new GajiImport, $file)[0][0];

            // Define the required keys
            $requiredKeys = ['id', 'sdm_id', 'chat_id', 'bulan', 'created_at', 'updated_at', 'nama', 'email', 'status', 'nik', 'jenis_kelamin', 'jabatan', 'tunjangan_jabatan', 'entitas', 'divisi', 'gaji_pokok'];

            // Check if all required keys are present in the Excel file
            if (count(array_diff($requiredKeys, array_keys($firstRow))) > 0) {
                // If any required key is missing, redirect with an error message
                return redirect()->route('admin.gaji.index')->with([
                    'error' => 'File Excel tidak sesuai. Pastikan file berisi semua kunci yang diperlukan.',
                    'alert-danger' => 'danger',
                ]);
            }

            // Use the GajiImport class to import data from the Excel file
            Excel::import(new GajiImport, $file);

            // Redirect back with a success message
            return redirect()->route('admin.gaji.index')->with([
                'success' => 'Data telah berhasil diimpor.',
                'alert-info' => 'info',
            ]);
        } catch (\Exception $e) {
            // Jika terjadi kesalahan, redirect dengan pesan kesalahan
            return redirect()->route('admin.gaji.index')->with([
                'error' => 'Terjadi kesalahan saat mengimpor data. Pastikan format file Excel sesuai.',
                'alert-danger' => 'danger',
            ]);
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
                'gaji_pokok',
                'chat_id'
            )
            ->where('bulan', $tanggal)
            ->where('chat_id', $chat_id)
            ->get();

        // Pastikan data ditemukan
        if ($items->isNotEmpty()) {
            // Generate URL untuk endpoint print PDF
            $pdfEndpoint = route('slip-pdf', [
                'chat_id' => $chat_id,
                'bulan' => $bulan,
                'tahun' => $tahun,
            ]);

            // Ubah nama rute di dalam pesan JSON
            $response = [
                'status' => 'success',
                'message' => 'Slip Gaji ditemukan',
                'pdf_link' => $pdfEndpoint,
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

    public function slipPDF(Request $request, $chat_id, $bulan, $tahun)
    {
        // Logika untuk menghasilkan PDF
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
                'gaji_pokok',
                'chat_id'
            )
            ->where('bulan', $tanggal)
            ->where('chat_id', $chat_id)
            ->get();

        // Pastikan data ditemukan
        if ($items->isNotEmpty()) {
            $item = $items->first(); // Mengambil hanya satu baris karena asumsi Anda hanya ingin satu item
            $timestamp = time();

            // Dapatkan data entitas berdasarkan nama
            $entitas = \App\Models\Entitas::where('nama', $item->entitas)->first();

            // Generate PDF menggunakan DomPDF
            $pdf = PDF::loadView('admin.laporan.cetak-gaji', compact('items', 'bulan', 'namaBulan', 'tahun'));

            // Set password pengguna (timestamp) untuk PDF
            $pdf->setEncryption($timestamp, '', ['print', 'copy'], 0);

            // Dapatkan konten PDF
            $pdfContent = $pdf->output();

            // Set header untuk menentukan tipe file sebagai PDF dan menentukan untuk menampilkan langsung (inline)
            $fileName = $item->entitas . '_' . $item->nama . '_' . $timestamp . '.pdf'; // Ubah file name sesuai dengan permintaan
            $headers = [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $fileName . '"', // Menggunakan file name yang baru
            ];

            // Berikan respons dengan file PDF
            return response()->make($pdfContent, 200, $headers);
        } else {
            // Handle jika data tidak ditemukan
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
    }




    // public function printPDF(Request $request, $chat_id, $bulan, $tahun)
    // {
    //     $namaBulan = $this->konversiBulan($bulan);
    //     $tanggal = $bulan . $tahun;

    //     // Ambil data absensi termasuk chat_id
    //     $items = DB::table('absensi')
    //         ->select(
    //             'sdm_id',
    //             'bulan',
    //             'nama',
    //             'email',
    //             'nik',
    //             'jenis_kelamin',
    //             'entitas',
    //             'divisi',
    //             'jabatan',
    //             'tunjangan_jabatan',
    //             'tunjangan',
    //             'potongan',
    //             'gaji_pokok',
    //             'chat_id'
    //         )
    //         ->where('bulan', $tanggal)
    //         ->where('chat_id', $chat_id)
    //         ->get();

    //     // Pastikan data ditemukan
    //     if ($items->isNotEmpty()) {
    //         $item = $items->first(); // Mengambil hanya satu baris karena asumsi Anda hanya ingin satu item
    //         $timestamp = time();

    //         // Dapatkan data entitas berdasarkan nama
    //         $entitas = \App\Models\Entitas::where('nama', $item->entitas)->first();


    //         // Generate PDF menggunakan DomPDF
    //         $pdf = PDF::loadView('admin.laporan.cetak-gaji', compact('items', 'bulan', 'namaBulan', 'tahun'));
    //         $pdf->setEncryption($timestamp, '', ['print', 'copy'], 0);
    //         $pdfContent = $pdf->output();

    //         // Response PDF langsung sebagai file download
    //         $response = Response::make($pdfContent, 200);
    //         $response->header('Content-Type', 'application/pdf');
    //         $response->header('Content-Disposition', 'attachment; filename=Slip_' . $item->entitas . '_' . $item->nama . '_' . $timestamp . '.pdf');
    //         $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
    //         $response->header('Cache-Control', 'post-check=0, pre-check=0');
    //         $response->header('Pragma', 'no-cache');

    //         return $response;
    //     } else {
    //         // Handle the case when there is no data found
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Slip Gaji yang diminta belum tersedia',
    //         ], 404);
    //     }
    // }


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
