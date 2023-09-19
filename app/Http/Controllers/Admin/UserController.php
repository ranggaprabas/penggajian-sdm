<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Jabatan;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Models\Entitas;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('jabatan', 'entitas')->paginate();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Add SDM';
        $pages = 'SDM';
        $jabatans = Jabatan::get(['id', 'nama']);
        $entita = Entitas::get(['id', 'nama']);

        return view('admin.users.create', compact('jabatans', 'entita', 'pages', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        if($request->validated()) {
            User::create($request->except('password') + ['password' => bcrypt($request->password)]);
        }

        return redirect()->route('admin.users.index')->with([
            'message' => 'berhasil di buat',
            'alert-info' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $title = 'Detail SDM';
        $pages = 'SDM';
        return view('admin.users.show', compact('user', 'title', 'pages'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $title = 'Edit SDM';
        $pages = 'SDM';
        $jabatans = Jabatan::get(['id', 'nama']);
        $entita = Entitas::get(['id', 'nama']);

        return view('admin.users.edit', compact('user', 'jabatans', 'entita', 'pages', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        if($request->validated()) {
            $user->update($request->except('password') + ['password' => bcrypt($request->password)]);
        }
        return redirect()->route('admin.users.index')->with([
            'message' => 'berhasil di edit',
            'alert-info' => 'info'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data SDM Berhasil Dihapus!.',
        ]);
    }
}
