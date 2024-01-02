<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jabatan;
use App\Http\Requests\Admin\JabatanRequest;
use App\Models\LogActivity;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $query = Jabatan::select('jabatan.*', 'log_activities.action', 'log_activities.date_created as last_update', 'users.nama as username')
            ->leftJoin('log_activities', function ($join) {
                $join->on('log_activities.row_id', '=', 'jabatan.id')
                    ->where('log_activities.table_name', '=', 'jabatan')
                    ->whereRaw('log_activities.id = (SELECT MAX(id) FROM log_activities WHERE log_activities.row_id = jabatan.id AND log_activities.table_name = "jabatan")');
            })
            ->leftJoin('users', 'users.id', '=', 'log_activities.user_id');

        if ($user->status == 1) {
            // Jika user memiliki status 1 (superadmin), tampilkan semua divisi
            $items = $query->get();
        } else {
            // Jika tidak, tampilkan divisi yang sesuai dengan entitas user
            $items = $query->where('jabatan.entitas_id', $user->entitas_id)->get();
        }

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
        $validatedData = $request->validated();
        $validatedData['entitas_id'] = Auth::user()->entitas_id;

        $jabatan = Jabatan::create($validatedData);

        LogActivity::create([
            'table_name' => 'jabatan',
            'row_id' => $jabatan->id,
            'user_id' => auth()->user()->id,
            'action' => 'add',
            'date_created' => now()->format('Y:m:d H:i:s'),
        ]);

        $jabatanNama = $request->input('nama'); // Mendapatkan nama jabatan dari request

        return redirect()->route('admin.jabatan.index')->with([
            'success' => 'Data Jabatan ' . $jabatanNama . ' berhasil ditambahkan!',
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
        $user = auth()->user();
        $data = Jabatan::findOrFail($id);
        // Jika pengguna bukan superadmin (status != 1) dan entitas_id tidak sesuai, tampilkan 404
        if ($user->status != 1 && $data->entitas_id != $user->entitas_id) {
            abort(404);
        }
        return view('admin.jabatan.edit', compact('pages', 'title', 'data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JabatanRequest $request, Jabatan $jabatan)
    {
        $validatedData = $request->validated();
        $validatedData['entitas_id'] = Auth::user()->entitas_id;

        $jabatan->update($validatedData);

        LogActivity::where('table_name', 'jabatan')
            ->where('row_id', $jabatan->id)
            ->delete();

        LogActivity::create([
            'table_name' => 'jabatan',
            'row_id' => $jabatan->id,
            'user_id' => auth()->user()->id,
            'action' => 'edit',
            'date_created' => now()->format('Y:m:d H:i:s')
        ]);

        // Membuat pesan sukses
        $message = 'Data Jabatan ' . $jabatan->nama . ' berhasil diperbarui!';

        return redirect()->route('admin.jabatan.index')->with([
            'success' => $message,
            'alert-info' => 'info',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $jabatan = Jabatan::findOrFail($id);

        // Menghapus data log activity yang terkait dengan jabatan
        LogActivity::where('table_name', 'jabatan')
            ->where('row_id', $jabatan->id)
            ->delete();

        // Mengubah nilai "deleted" menjadi 1 (true) alih-alih menghapus data
        $jabatan->deleted = 1;
        $jabatan->save();


        // Mengembalikan response JSON
        return response()->json([
            'success' => true,
            'message' => 'Data Jabatan ' . $jabatan->nama . ' berhasil dihapus!.',
        ]);
    }
}
