<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Jabatan;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Models\Entitas;
use App\Models\KomponenGaji;
use App\Models\PotonganGaji;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('jabatan', 'entitas')
            ->where('deleted', 0)
            ->get();
        $isDeletedPage = false;
        return view('admin.users.index', compact('users', 'isDeletedPage'));
    }

    public function indexDeleted()
    {
        $users = User::with('jabatan', 'entitas')
            ->where('deleted', 1)
            ->get();

        $isDeletedPage = true;
        return view('admin.users.index', compact('users', 'isDeletedPage'));
    }


    public function searchResponse(Request $request)
    {
        $query = $request->get('term', '');
        $tunjangan = KomponenGaji::query();
        if ($request->type == 'namatunjangan') {
            $tunjangan->where('nama_tunjangan', 'LIKE', '%' . $query . '%');
        }

        $tunjangan = $tunjangan->get();
        $data = array();
        foreach ($tunjangan as $tunjangans) {
            $data[] = array('nama_tunjangan' => $tunjangans->nama_tunjangan);
        }
        if (count($data))
            return $data;
        else
            return ['nama_tunjangan' => ''];
    }

    public function searchResponsePotongan(Request $request)
    {
        $query = $request->get('term', '');
        $potongan = PotonganGaji::query();
        if ($request->type == 'namapotongan') {
            $potongan->where('nama_potongan', 'LIKE', '%' . $query . '%');
        }

        $potongan = $potongan->get();
        $data = array();
        foreach ($potongan as $potongans) {
            $data[] = array('nama_potongan' => $potongans->nama_potongan);
        }
        if (count($data))
            return $data;
        else
            return ['nama_potongan' => ''];
    }





    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Add SDM';
        $pages = 'SDM';
        $jabatans = Jabatan::get(['id', 'nama', 'tunjangan_jabatan', 'deleted']);
        $entita = Entitas::get(['id', 'nama']);

        return view('admin.users.create', compact('jabatans', 'entita', 'pages', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $user = User::create($request->validated());

        $namaTunjangan = $request->input('nama_tunjangan');
        $nilaiTunjangan = $request->input('nilai_tunjangan');

        // Loop melalui data tunjangan dan simpan dalam model KomponenGaji
        if (is_array($namaTunjangan) && is_array($nilaiTunjangan)) {
            for ($i = 0; $i < count($namaTunjangan); $i++) {
                $nama = ucwords($namaTunjangan[$i]); // ucwords berfungsi Mengubah huruf pertama menjadi besar
                $nilai = $nilaiTunjangan[$i];

                // Periksa apakah input adalah "Default Nama" atau "Default Nilai" atau kosong/null
                if (empty($nama) || $nilai === null || $nilai === '') {
                    continue; // Lewati jika nama kosong atau nilai adalah null atau kosong
                }

                $tunjangan = new KomponenGaji([
                    'nama_tunjangan' => $nama,
                    'nilai_tunjangan' => $nilai,
                ]);

                $user->komponenGajis()->save($tunjangan); // Sambungkan tunjangan ke user
            }
        }

        // Simpan juga potongan gaji dengan konsep yang serupa
        $namaPotongan = $request->input('nama_potongan');
        $nilaiPotongan = $request->input('nilai_potongan');

        // Loop melalui data tunjangan dan simpan dalam model KomponenGaji
        if (is_array($namaPotongan) && is_array($nilaiPotongan)) {
            for ($i = 0; $i < count($namaPotongan); $i++) {
                $nama = ucwords($namaPotongan[$i]);
                $nilai = $nilaiPotongan[$i];

                // Periksa apakah input adalah "Default Nama" atau "Default Nilai" atau kosong/null
                if (empty($nama) || $nilai === null || $nilai === '') {
                    continue; // Lewati jika nama kosong atau nilai adalah null atau kosong
                }

                $potongan = new PotonganGaji([
                    'nama_potongan' => $nama,
                    'nilai_potongan' => $nilai,
                ]);

                $user->potonganGajis()->save($potongan);
            }
        }

        $userNama = $request->input('nama');

        return redirect()->route('admin.users.index')->with([
            'success' => 'Data SDM ' . $userNama . ' berhasil ditambahkan!',
            'alert-info' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $title = 'Detail SDM';
        $pages = 'SDM';
        $data = User::findOrFail($id);
        $details = User::with('komponenGaji', 'potonganGaji')->findOrFail($id);
        return view('admin.users.show', compact('title', 'pages', 'data', 'details'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = 'Edit SDM';
        $pages = 'SDM';
        // Ambil data pengguna berdasarkan ID
        $user = User::findOrFail($id);

        // Ambil data tunjangan yang terkait dengan pengguna
        $tunjangan = $user->komponenGaji;
        
        // Ambil data potongan yang terkait dengan pengguna
        $potongan = $user->potonganGaji;

        $jabatans = Jabatan::get(['id', 'nama', 'tunjangan_jabatan', 'deleted']);
        $entita = Entitas::get(['id', 'nama']);

        return view('admin.users.edit', compact('user', 'tunjangan', 'potongan',  'jabatans', 'entita', 'pages', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        $user->update($request->validated());


        // Tunjangan Gaji

        // Ambil daftar ID tunjangan yang dikirimkan dalam permintaan
        $tunjanganIds = $request->input('tunjangan_ids', []);

        $existingTunjangan = $user->komponenGaji;

        // Buat daftar tunjangan yang harus dihapus
        $tunjanganToRemove = $existingTunjangan->filter(function ($tunjangan) use ($tunjanganIds) {
            return !in_array($tunjangan->id, $tunjanganIds);
        });

        // Hapus tunjangan yang ditandai untuk dihapus
        foreach ($tunjanganToRemove as $tunjangan) {
            $tunjangan->delete();
        }

        // Loop melalui data tunjangan yang dikirim dalam request
        foreach ($request->input('nama_tunjangan', []) as $key => $nama) {
            $nilai = $request->input('nilai_tunjangan')[$key];
            $nama = ucwords($nama); // ucwords berfungsi menngubah nama depan menjadi besar

            if (isset($existingTunjangan[$key])) {
                $existingTunjangan[$key]->update([
                    'nama_tunjangan' => $nama,
                    'nilai_tunjangan' => $nilai,
                ]);
            } else {
                $tunjangan = new KomponenGaji([
                    'nama_tunjangan' => $nama,
                    'nilai_tunjangan' => $nilai,
                ]);

                $user->komponenGaji()->save($tunjangan);
            }
        }


        // Potongan Gaji
        $potonganIds = $request->input('potongan_ids', []);

        $existingPotongan = $user->potonganGaji;

        // Buat daftar potongan yang harus dihapus
        $potonganToRemove = $existingPotongan->filter(function ($potongan) use ($potonganIds) {
            return !in_array($potongan->id, $potonganIds);
        });

        // Hapus potongan yang ditandai untuk dihapus
        foreach ($potonganToRemove as $potongan) {
            $potongan->delete();
        }

        // Loop melalui data potongan yang dikirim dalam request
        foreach ($request->input('nama_potongan', []) as $key => $nama) {
            $nilai = $request->input('nilai_potongan')[$key];
            $nama = ucwords($nama);

            if (isset($existingPotongan[$key])) {
                $existingPotongan[$key]->update([
                    'nama_potongan' => $nama,
                    'nilai_potongan' => $nilai,
                ]);
            } else {
                $potongan = new PotonganGaji([
                    'nama_potongan' => $nama,
                    'nilai_potongan' => $nilai,
                ]);

                $user->potonganGaji()->save($potongan);
            }
        }


        $message = 'Data SDM ' . $user->nama  . ' berhasil diperbarui!';

        return redirect()->route('admin.users.index')->with([
            'success' => $message,
            'alert-info' => 'info'
        ]);
    }





    public function restore(User $user)
    {
        $user->update(['deleted' => 0]);

        return response()->json(['message' => 'Data SDM ' . $user->nama . ' Berhasil diaktifkan.']);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Mengubah nilai "deleted" menjadi 1 (true) alih-alih menghapus data
        $user->deleted = 1;
        $user->save();

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data SDM ' . $user->nama . ' Berhasil Dinonaktifkan!.',
        ]);
    }
}
