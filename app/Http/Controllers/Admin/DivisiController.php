<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DivisiRequest;
use App\Models\Divisi;
use App\Models\User;
use Illuminate\Http\Request;

class DivisiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Divisi::all();

        return view('admin.divisi.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Add Divisi';
        $pages = "Divisi";
        return view('admin.divisi.create', compact('pages', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DivisiRequest $request)
    {
        Divisi::create($request->validated());

        $divisiNama = $request->input('nama');

        return redirect()->route('admin.divisi.index')->with([
            'message' => 'Data Divisi ' . $divisiNama . ' berhasil ditambahkan!',
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
        $title = 'Edit Divisi';
        $pages = "Divisi";
        $data = Divisi::findOrFail($id);
        return view('admin.divisi.edit', compact('pages', 'title', 'data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DivisiRequest $request, Divisi $divisi)
    {
        $divisi->update($request->validated());

        // Membuat pesan sukses
        $message = 'Data Divisi ' . $divisi->nama . ' berhasil diperbarui!';

        return redirect()->route('admin.divisi.index')->with([
            'success' => $message,
            'alert-info' => 'info'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $divisi = Divisi::findOrFail($id);

        // Menghapus divisi
        $divisi->delete();

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Divisi ' . $divisi->nama . ' Berhasil Dihapus!.',
        ]);
    }
}
