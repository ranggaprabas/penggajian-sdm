<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Divisi;
use App\Models\Entitas;
use App\Models\Jabatan;
use App\Models\Sdm;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
        $user = Auth::user();

        if ($user->status == 1) {
            // Menghitung jumlah pria (Laki-laki) berdasarkan entitas_id pengguna
            $maleCount = Sdm::where('jenis_kelamin', 'laki-laki')
                ->where('deleted', '!=', 1)
                ->count();

            // Menghitung jumlah wanita (Perempuan) berdasarkan entitas_id pengguna
            $femaleCount = Sdm::where('jenis_kelamin', 'perempuan')
                ->where('deleted', '!=', 1)
                ->count();

            // Menghitung jumlah total SDM berdasarkan entitas_id pengguna
            $employee_count = Sdm::where('deleted', '!=', 1)
                ->count();

            $entita_count = Entitas::count();
            $divisi_count = Divisi::count();
            $jabatan_count = Jabatan::where('deleted', '!=', 1)->count();
        } else {
            // Menghitung jumlah pria (Laki-laki) berdasarkan entitas_id pengguna
            $maleCount = Sdm::where('jenis_kelamin', 'laki-laki')
                ->where('entitas_id', $user->entitas_id)
                ->where('deleted', '!=', 1)
                ->count();

            // Menghitung jumlah wanita (Perempuan) berdasarkan entitas_id pengguna
            $femaleCount = Sdm::where('jenis_kelamin', 'perempuan')
                ->where('entitas_id', $user->entitas_id)
                ->where('deleted', '!=', 1)
                ->count();

            // Menghitung jumlah total SDM berdasarkan entitas_id pengguna
            $employee_count = Sdm::where('entitas_id', $user->entitas_id)
                ->where('deleted', '!=', 1)
                ->count();

            $entita_count = Entitas::count();
            $divisi_count = Divisi::where('entitas_id', $user->entitas_id)
                ->count();
            $jabatan_count = Jabatan::where('deleted', '!=', 1)
            ->where('entitas_id', $user->entitas_id)
            ->count();
        }

        return view('home', compact('employee_count', 'entita_count', 'divisi_count', 'jabatan_count', 'maleCount', 'femaleCount', 'user'));
    }
}
