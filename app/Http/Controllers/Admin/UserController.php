<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware(['auth', function ($request, $next) {
            if (auth()->user() && auth()->user()->status !== 1) {
                abort(403, 'Unauthorized');
            }
            return $next($request);
        }])->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']);
    }

    public function index()
    {
        $admins = User::all();
        return view('admin.users.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Add Admin';
        $pages = 'Admin';


        return view('admin.users.create', compact('pages', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($request->input('password')); // Hash the password
        $data['is_admin'] = 1;
        User::create($data);

        $userNama = $request->input('nama');

        return redirect()->route('admin.users.index')->with([
            'success' => 'Data Admin ' . $userNama . ' berhasil ditambahkan!',
            'alert-info' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $title = 'Detail Admin';
        $pages = 'Admin';
        $data = User::findOrFail($id);
        return view('admin.users.show', compact('title', 'pages', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = 'Edit Admin';
        $pages = 'Admin';
        // Ambil data pengguna berdasarkan ID
        $user = User::findOrFail($id);


        return view('admin.users.edit', compact('user', 'pages', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        $data = $request->validated();

        if (!empty($request->input('password'))) {
            $data['password'] = Hash::make($request->input('password'));
        } else {
            unset($data['password']);
        }
        $data['is_admin'] = 1;

        $user->update($data);

        $message = 'Data Admin ' . $user->nama  . ' berhasil diperbarui!';

        return redirect()->route('admin.users.index')->with([
            'success' => $message,
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
            'message' => 'Data Admin '. $user->nama .' Berhasil Dihapus!.',
        ]);
    }
}
