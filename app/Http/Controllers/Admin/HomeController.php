<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Divisi;
use App\Models\Entitas;
use App\Models\Jabatan;
use App\Models\Sdm;
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
        // Menghitung jumlah pria (Laki-laki)
        $maleCount = Sdm::where('jenis_kelamin', 'laki-laki')->where('deleted', '!=', 1)->count();

        // Menghitung jumlah wanita (Perempuan)
        $femaleCount = Sdm::where('jenis_kelamin', 'perempuan')->where('deleted', '!=', 1)->count();

        // Menghitung jumlah entitas
        $crocodicCount = Sdm::where('entitas_id', '1')->where('deleted', '!=', 1)->count();
        $eventyCount = Sdm::where('entitas_id', '2')->where('deleted', '!=', 1)->count();
        $reprimeCount = Sdm::where('entitas_id', '3')->where('deleted', '!=', 1)->count();
        $taarufCount = Sdm::where('entitas_id', '4')->where('deleted', '!=', 1)->count();

        $employee_count = Sdm::where('deleted', '!=', 1)->count();
        $entita_count = Entitas::count();
        $divisi_count = Divisi::count();
        $jabatan_count = Jabatan::where('deleted', '!=', 1)->count();

        return view('home', compact('employee_count', 'entita_count','divisi_count', 'jabatan_count', 'maleCount', 'femaleCount', 'crocodicCount', 'eventyCount', 'reprimeCount', 'taarufCount'));
    }
}
