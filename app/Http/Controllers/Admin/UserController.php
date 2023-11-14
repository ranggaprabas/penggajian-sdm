<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Models\LogActivity;
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
                abort(404, 'Unauthorized');
            }
            return $next($request);
        }])->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']);
    }

    public function index()
    {
        $admins = User::select('users.*', 'log_activities.action', 'log_activities.date_created as last_update', 'u2.nama as username')
            ->leftJoin('log_activities', function ($join) {
                $join->on('log_activities.row_id', '=', 'users.id')
                    ->where('log_activities.table_name', '=', 'users')
                    ->whereRaw('log_activities.id = (SELECT MAX(id) FROM log_activities WHERE log_activities.row_id = users.id AND log_activities.table_name = "users")');
            })
            ->leftJoin('users as u2', 'u2.id', '=', 'log_activities.user_id')
            ->get();
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
        $user = User::create($data);

        LogActivity::create([
            'table_name' => 'users',
            'row_id' => $user->id,
            'user_id' => auth()->user()->id,
            'action' => 'add',
            'date_created' => now()->format('Y-m-d H:i:s')
        ]);

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

        LogActivity::where('table_name', 'users')
            ->where('row_id', $user->id)
            ->delete();

        LogActivity::create([
            'table_name' => 'users',
            'row_id' => $user->id,
            'user_id' => auth()->user()->id,
            'action' => 'edit',
            'date_created' => now()->format('Y-m-d H:i:s')
        ]);

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

        LogActivity::where('table_name', 'users')
            ->where('row_id', $user->id)
            ->delete();

        $user->delete();

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Admin ' . $user->nama . ' Berhasil Dihapus!.',
        ]);
    }
}
