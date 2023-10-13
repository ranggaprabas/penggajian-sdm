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

        $filterResult = KomponenGaji::where('user_nama', 'LIKE', '%' . $query . '%')
            ->orWhere('tunjangan_makan', 'LIKE', '%' . $query . '%')
            ->orWhere('tunjangan_transportasi', 'LIKE', '%' . $query . '%')
            ->orWhere('potongan_pinjaman', 'LIKE', '%' . $query . '%')
            ->get();

        // Filter hasil kueri untuk menghindari 'is_admin' = 1
        $filteredResult = $filterResult->filter(function ($item) {
            return $item->user->is_admin != 1 && $item->user->deleted != 1;
        });

        $formattedResult = $filteredResult->map(function ($item) {
            return [
                'user_nama' => $item->user_nama,
                'tunjangan_makan' => $item->tunjangan_makan,
                'tunjangan_transportasi' => $item->tunjangan_transportasi,
                'potongan_pinjaman' => $item->potongan_pinjaman,
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

        // Simpan data ke tabel komponen_gaji
        $user->komponenGaji()->create([
            'tunjangan_makan' => $request->input('tunjangan_makan'),
            'tunjangan_transportasi' => $request->input('tunjangan_transportasi'),
            'potongan_pinjaman' => $request->input('potongan_pinjaman'),
            'user_nama' => $request->input('nama'),
        ]);

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
        $data = User::findOrFail($id);
        $details = User::with('komponenGaji')->findOrFail($id);
        $jabatans = Jabatan::get(['id', 'nama', 'tunjangan_jabatan', 'deleted']);
        $entita = Entitas::get(['id', 'nama']);

        return view('admin.users.edit', compact('data', 'details',  'jabatans', 'entita', 'pages', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        $user->update($request->validated());

        // Perbarui data komponen_gaji jika ada
        if ($user->komponenGaji) {
            $user->komponenGaji->update([
                'tunjangan_makan' => $request->input('tunjangan_makan'),
                'tunjangan_transportasi' => $request->input('tunjangan_transportasi'),
                'potongan_pinjaman' => $request->input('potongan_pinjaman'),
                'user_nama' => $request->input('nama'), // Perbarui user_nama dengan nilai dari input nama
            ]);
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
