<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DivisiRequest;
use App\Models\Divisi;
use App\Models\LogActivity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DivisiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Divisi";
        $user = Auth::user();

        $query = Divisi::select('divisis.*', 'log_activities.action', 'log_activities.date_created as last_update', 'users.nama as username')
            ->leftJoin('log_activities', function ($join) {
                $join->on('log_activities.row_id', '=', 'divisis.id')
                    ->where('log_activities.table_name', '=', 'divisis')
                    ->whereRaw('log_activities.id = (SELECT MAX(id) FROM log_activities WHERE log_activities.row_id = divisis.id AND log_activities.table_name = "divisis")');
            })
            ->leftJoin('users', 'users.id', '=', 'log_activities.user_id');

        if ($user->status == 1) {
            // Jika user memiliki status 1 (superadmin), tampilkan semua divisi
            $items = $query->get();
        } else {
            // Jika tidak, tampilkan divisi yang sesuai dengan entitas user
            $items = $query->where('divisis.entitas_id', $user->entitas_id)->get();
        }

        return view("admin.divisi.index", compact('title', 'items'));
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
        $validatedData = $request->validated();
        $validatedData['entitas_id'] = Auth::user()->entitas_id;

        $divisi = Divisi::create($validatedData);

        LogActivity::create([
            'table_name' => 'divisis',
            'row_id' => $divisi->id,
            'user_id' => auth()->user()->id,
            'action' => 'add',
            'date_created' => now()->format('Y-m-d H:i:s')
        ]);

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
        $user = auth()->user();

        $data = Divisi::findOrFail($id);

        // Jika pengguna bukan superadmin (status != 1) dan entitas_id tidak sesuai, tampilkan 404
        if ($user->status != 1 && $data->entitas_id != $user->entitas_id) {
            abort(404);
        }
        return view('admin.divisi.edit', compact('pages', 'title', 'data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DivisiRequest $request, Divisi $divisi)
    {
        $validatedData = $request->validated();
        $validatedData['entitas_id'] = Auth::user()->entitas_id;

        $divisi->update($validatedData);

        LogActivity::where('table_name', 'divisis')
            ->where('row_id', $divisi->id)
            ->delete();

        LogActivity::create([
            'table_name' => 'divisis',
            'row_id' => $divisi->id,
            'user_id' => auth()->user()->id,
            'action' => 'edit',
            'date_created' => now()->format('Y-m-d H:i:s')
        ]);


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

        // Delete associated log activities
        LogActivity::where('table_name', 'divisis')
            ->where('row_id', $divisi->id)
            ->delete();

        // Menghapus divisi
        $divisi->delete();

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Divisi ' . $divisi->nama . ' Berhasil Dihapus!.',
        ]);
    }
}
