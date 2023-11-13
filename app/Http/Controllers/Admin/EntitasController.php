<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EntitasRequest;
use App\Models\Entitas;
use App\Models\LogActivity;
use App\Models\User;
use Illuminate\Http\Request;

class EntitasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Entitas::select('entitas.*', 'log_activities.action', 'log_activities.date_created as last_update', 'users.nama as username')
            ->leftJoin('log_activities', function ($join) {
                $join->on('log_activities.row_id', '=', 'entitas.id')
                    ->where('log_activities.table_name', '=', 'entitas')
                    ->whereRaw('log_activities.id = (SELECT MAX(id) FROM log_activities WHERE log_activities.row_id = entitas.id AND log_activities.table_name = "entitas")');
            })
            ->leftJoin('users', 'users.id', '=', 'log_activities.user_id')
            ->get();

        return view('admin.entitas.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Add Entitas';
        $pages = "Entitas";
        return view('admin.entitas.create', compact('pages', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EntitasRequest $request)
    {
        $entitas = Entitas::create($request->validated());

        LogActivity::create([
            'table_name' => 'entitas',
            'row_id' => $entitas->id,
            'user_id' => auth()->user()->id,
            'action' => 'add',
            'date_created' => now()->format('Y:m:d H:i:s'),
        ]);

        $entitasNama = $request->input('nama');

        return redirect()->route('admin.entitas.index')->with([
            'message' => 'Data Entitas ' . $entitasNama . ' berhasil ditambahkan!',
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
        $title = 'Edit Entitas';
        $pages = "Entitas";
        $data = Entitas::findOrFail($id);
        return view('admin.entitas.edit', compact('pages', 'title', 'data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EntitasRequest $request, Entitas $entita)
    {
        $entita->update($request->validated());

        LogActivity::create([
            'table_name' => 'entitas',
            'row_id' => $entita->id,
            'user_id' => auth()->user()->id,
            'action' => 'edit',
            'date_created' => now()->format('Y:m:d H:i:s')
        ]);

        // Membuat pesan sukses
        $message = 'Data Entitas ' . $entita->nama . ' berhasil diperbarui!';

        return redirect()->route('admin.entitas.index')->with([
            'success' => $message,
            'alert-info' => 'info'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $entita = Entitas::findOrFail($id);

        // Menghapus hubungan entitas pada setiap user
        $users = User::where('entitas_id', $entita->id)->get();
        foreach ($users as $user) {
            $user->entitas_id = null;
            $user->save();
        }

        // Menghapus entitas
        $entita->delete();

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Entitas ' . $entita->nama . ' Berhasil Dihapus!.',
        ]);
    }
}
