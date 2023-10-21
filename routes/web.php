<?php

use App\Http\Controllers\Admin\EntitasController;
use App\Http\Controllers\Admin\JabatanController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes(['register' => false]);

Route::get('/users/create/searchResponse', [UserController::class, 'searchResponse'])->name('searchajax');



Route::group(['middleware' => ['auth'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::group(['middleware' => ['is_admin']], function () {
        Route::get('entitas/edit/{id}', [EntitasController::class, 'edit'])->name('edit-entitas');
        Route::resource('entitas', App\Http\Controllers\Admin\EntitasController::class);
        Route::get('jabatan/edit/{id}', [JabatanController::class, 'edit'])->name('edit-jabatan');
        Route::resource('jabatan', App\Http\Controllers\Admin\JabatanController::class);
        Route::delete('users/restore/{user}', [UserController::class, 'restore'])->name('admin.users.restore');
        Route::get('users/resign', [UserController::class, 'indexDeleted'])->name('users.index.deleted');
        Route::get('users/edit/{id}', [UserController::class, 'edit'])->name('edit-users');
        Route::resource('users', App\Http\Controllers\Admin\UserController::class);
        Route::get('kehadiran', [App\Http\Controllers\Admin\AbsensiController::class, 'index'])->name('absensis.index');
        Route::get('gaji/input-gaji', [App\Http\Controllers\Admin\AbsensiController::class, 'show'])->name('absensis.show');
        Route::post('gaji/input-gaji', [App\Http\Controllers\Admin\AbsensiController::class, 'store'])->name('absensis.store');
        Route::resource('gaji', App\Http\Controllers\Admin\GajiController::class);
        Route::get('gaji', [App\Http\Controllers\Admin\GajiController::class, 'index'])->name('gaji.index');
        Route::get('gaji/cetak/{bulan}/{tahun}', [App\Http\Controllers\Admin\GajiController::class, 'cetak'])->name('gaji.cetak');
        Route::get('laporan/slip-gaji', [App\Http\Controllers\Admin\LaporanController::class, 'index'])->name('laporan.index');
        Route::post('laporan/slip-gaji', [App\Http\Controllers\Admin\LaporanController::class, 'store'])->name('laporan.store');
    });
    Route::get('home', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('home');
    Route::get('laporan/slip-gaji/karyawan', [App\Http\Controllers\Admin\LaporanController::class, 'show'])->name('laporan.show');
    Route::post('laporan/slip-gaji/karyawan', [App\Http\Controllers\Admin\LaporanController::class, 'cekGaji'])->name('laporan.karyawan');

    Route::get('profile', [\App\Http\Controllers\Admin\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');
});
