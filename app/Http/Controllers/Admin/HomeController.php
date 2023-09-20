<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Entitas;
use App\Models\Jabatan;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $employee_count = User::where('is_admin', '!=', 1)->count();
        $entita_count = Entitas::count();
        $jabatan_count = Jabatan::count();
        return view('home',compact('employee_count', 'entita_count', 'jabatan_count'));

    }
}
