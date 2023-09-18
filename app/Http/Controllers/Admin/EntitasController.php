<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EntitasRequest;
use App\Models\Entitas;
use App\Models\User;
use Illuminate\Http\Request;

class EntitasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Entitas::paginate();

        return view('admin.entitas.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.entitas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EntitasRequest $request)
    {
        Entitas::create($request->validated());

        return redirect()->route('admin.entitas.index')->with([
            'message' => 'berhasil di buat',
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
    public function edit(Entitas $entita)
    {
        return view('admin.entitas.edit', compact('entita'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EntitasRequest $request, Entitas $entita)
    {
        $entita->update($request->validated());

        return redirect()->route('admin.entitas.index')->with([
            'message' => 'berhasil di edit',
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
            'message' => 'Data Entitas Berhasil Dihapus!.',
        ]);
    }
}
