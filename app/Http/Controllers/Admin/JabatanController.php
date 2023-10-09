<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jabatan;
use App\Http\Requests\Admin\JabatanRequest;
use App\Models\User;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Jabatan::all();

        return view('admin.jabatan.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Add Jabatan';
        $pages = 'Jabatan';
        return view('admin.jabatan.create', compact('title', 'pages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JabatanRequest $request)
    {
        Jabatan::create($request->validated());

        $jabatanNama = $request->input('nama'); // Mendapatkan nama jabatan dari request

        return redirect()->route('admin.jabatan.index')->with([
            'message' => 'Data Jabatan ' . $jabatanNama . ' berhasil ditambahkan!',
            'alert-info' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = 'Edit Jabatan';
        $pages = "Jabatan";
        $data = Jabatan::findOrFail($id);
        return view('admin.jabatan.edit', compact('pages', 'title', 'data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JabatanRequest $request, Jabatan $jabatan)
    {
        $jabatan->update($request->validated());

        // Membuat pesan sukses
        $message = 'Data Jabatan ' . $jabatan->nama . ' berhasil diperbarui!';

        return redirect()->route('admin.jabatan.index')->with([
            'message' => $message,
            'alert-info' => 'info',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $jabatan = Jabatan::findOrFail($id);

        // Mendapatkan semua user yang terkait dengan jabatan
        $users = User::where('jabatan_id', $jabatan->id)->get();

        // Menghapus hubungan jabatan pada setiap user
        foreach ($users as $user) {
            $user->jabatan_id = null;
            $user->save();
        }

        // Menghapus jabatan
        $jabatan->delete();

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Jabatan ' . $jabatan->nama . ' Berhasil Dihapus!.',
        ]);
    }
}
