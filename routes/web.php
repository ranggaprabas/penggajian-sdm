<?php

use App\Http\Controllers\Admin\BroadcastInformationController;
use App\Http\Controllers\Admin\EntitasController;
use App\Http\Controllers\Admin\DivisiController;
use App\Http\Controllers\Admin\GajiController;
use App\Http\Controllers\Admin\JabatanController;
use App\Http\Controllers\Admin\SdmController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\Setting;

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





Route::group(['middleware' => ['auth'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    // Get the TELEGRAM_BOT_TOKEN from the database and set it in .env
    $telegramSetting = Setting::where('telegram_bot_token', '!=', '')->first();

    if ($telegramSetting) {
        putenv("TELEGRAM_BOT_TOKEN={$telegramSetting->telegram_bot_token}");
        config(['telegram.bots.mybot.token' => $telegramSetting->telegram_bot_token]);
    }

    Route::group(['middleware' => ['is_admin']], function () {
        Route::get('settings', [SettingController::class, 'show'])->name('settings.show');
        Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
        Route::resource('broadcast-information', App\Http\Controllers\Admin\BroadcastInformationController::class);
        Route::get('divisi/edit/{id}', [DivisiController::class, 'edit'])->name('edit-divisi');
        Route::resource('divisi', App\Http\Controllers\Admin\DivisiController::class);
        Route::get('entitas/edit/{id}', [EntitasController::class, 'edit'])->name('edit-entitas');
        Route::resource('entitas', App\Http\Controllers\Admin\EntitasController::class);
        Route::get('jabatan/edit/{id}', [JabatanController::class, 'edit'])->name('edit-jabatan');
        Route::resource('jabatan', App\Http\Controllers\Admin\JabatanController::class);
        Route::delete('sdm/restore/{sdm}', [SdmController::class, 'restore'])->name('admin.sdm.restore');
        Route::get('sdm/resign', [SdmController::class, 'indexDeleted'])->name('sdm.index.deleted');
        Route::get('sdm/edit/{id}', [SdmController::class, 'edit'])->name('edit-sdm');
        Route::resource('sdm', App\Http\Controllers\Admin\SdmController::class);
        Route::get('users/edit/{id}', [UserController::class, 'edit'])->name('edit-users');
        Route::resource('users', App\Http\Controllers\Admin\UserController::class);
        // Route::get('kehadiran', [App\Http\Controllers\Admin\AbsensiController::class, 'index'])->name('absensis.index');
        Route::get('gaji/input-gaji', [App\Http\Controllers\Admin\AbsensiController::class, 'show'])->name('absensis.show');
        Route::post('gaji/input-gaji', [App\Http\Controllers\Admin\AbsensiController::class, 'store'])->name('absensis.store');
        Route::get('gaji/{id}/pdf/{bulan?}/{tahun?}', [GajiController::class, 'cetakPDF'])
            ->name('gaji.pdf');
        Route::get('gaji/export-excel/{bulan}/{tahun}', [GajiController::class, 'exportExcel'])->name('gaji.export-excel');
        Route::post('gaji/import-excel', [GajiController::class, 'importExcel'])->name('gaji.import-excel');
        Route::get('gaji/cetak/{bulan}/{tahun}', [GajiController::class, 'cetak'])->name('admin.gaji.cetak');
        Route::post('admin/gaji-serentak/{bulan?}/{tahun?}', [GajiController::class, 'gajiSerentak'])->name('gaji.gaji-serentak');
        Route::get('gaji/edit/{id}', [GajiController::class, 'edit'])->name('edit-gaji');
        Route::resource('gaji', App\Http\Controllers\Admin\GajiController::class);
        Route::get('gaji', [App\Http\Controllers\Admin\GajiController::class, 'index'])->name('gaji.index');
        Route::get('gaji/cetak/{bulan}/{tahun}', [App\Http\Controllers\Admin\GajiController::class, 'cetak'])->name('gaji.cetak');
        Route::get('laporan/slip-gaji', [App\Http\Controllers\Admin\LaporanController::class, 'index'])->name('laporan.index');
        Route::post('laporan/slip-gaji', [App\Http\Controllers\Admin\LaporanController::class, 'store'])->name('laporan.store');
    });
    Route::get('home', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('home');
    // Route::get('laporan/slip-gaji/karyawan', [App\Http\Controllers\Admin\LaporanController::class, 'show'])->name('laporan.show');
    // Route::post('laporan/slip-gaji/karyawan', [App\Http\Controllers\Admin\LaporanController::class, 'cekGaji'])->name('laporan.karyawan');

    Route::get('profile', [\App\Http\Controllers\Admin\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');
});
