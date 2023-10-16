<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Jabatan;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Models\Entitas;
use App\Models\KomponenGaji;
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


    public function autocompleteSearch(Request $request)
    {
        $query = $request->get('query');

        $filterResult = KomponenGaji::where('nama_tunjangan', 'LIKE', '%' . $query . '%')
            ->get();

        $formattedResult = $filterResult->map(function ($item) {
            return [
                'nama_tunjangan' => $item->nama_tunjangan,
            ];
        });

        return response()->json($formattedResult);
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

        $totalTunjangan = 0; // Inisialisasi total tunjangan

        // Loop melalui data tunjangan dan simpan dalam model KomponenGaji
        for ($i = 0; $i < count($namaTunjangan); $i++) {
            $nama = $namaTunjangan[$i];
            $nilai = $nilaiTunjangan[$i];

            $tunjangan = new KomponenGaji([
                'nama_tunjangan' => $nama,
                'nilai_tunjangan' => $nilai,
                'total_tunjangan' => $nilai, // Simpan total tunjangan pada setiap tunjangan
            ]);

            $user->komponenGajis()->save($tunjangan); // Sambungkan tunjangan ke user
            $totalTunjangan += $nilai; // Tambahkan nilai tunjangan ke total
        }

        // Simpan total tunjangan ke model User
        $user->komponenGajis->total_tunjangan = $totalTunjangan;
        $user->komponenGajis->save();

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
        $details = User::with('komponenGaji')->findOrFail($id);
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

        $jabatans = Jabatan::get(['id', 'nama', 'tunjangan_jabatan', 'deleted']);
        $entita = Entitas::get(['id', 'nama']);

        return view('admin.users.edit', compact('user', 'tunjangan',  'jabatans', 'entita', 'pages', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        $user->update($request->validated());

        // Ambil data tunjangan yang ada di database untuk pengguna yang bersangkutan
        $existingTunjangan = $user->komponenGaji;

        $namaTunjangan = $request->input('nama_tunjangan');
        $nilaiTunjangan = $request->input('nilai_tunjangan');

        $totalTunjangan = 0;

        // Loop melalui data tunjangan yang dikirim dalam request
        for ($i = 0; $i < count($namaTunjangan); $i++) {
            $nama = $namaTunjangan[$i];
            $nilai = $nilaiTunjangan[$i];

            // Jika tunjangan sudah ada, update nilainya; jika tidak, buat yang baru
            if (isset($existingTunjangan[$i])) {
                $existingTunjangan[$i]->update([
                    'nama_tunjangan' => $nama,
                    'nilai_tunjangan' => $nilai,
                    'total_tunjangan' => $nilai,
                ]);
            } else {
                $tunjangan = new KomponenGaji([
                    'nama_tunjangan' => $nama,
                    'nilai_tunjangan' => $nilai,
                    'total_tunjangan' => $nilai,
                ]);

                $user->komponenGaji()->save($tunjangan);
            }

            $totalTunjangan += $nilai;
        }

        // Hapus tunjangan yang tidak ada dalam request
        foreach ($existingTunjangan as $existing) {
            if (!in_array($existing->id, $request->input('tunjangan_ids', []))) {
                $existing->delete();
            }
        }

        foreach ($user->komponenGaji as $tunjangan) {
            $tunjangan->total_tunjangan = $totalTunjangan;
            $tunjangan->save();
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
