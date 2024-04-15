<?php

use App\Http\Controllers\Admin\GajiController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\LaporanApiController;
use App\Http\Controllers\API\PinjamanController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BotTelegramController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [AuthController::class, 'login'])->name('login');

//Protecting Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/user', function (Request $request) {
        return auth()->user();
    });
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::resource('pinjaman', PinjamanController::class);
    Route::post('/cetak-pdf', [LaporanApiController::class, 'store'])->name('cetak-pdf');
});

Route::get('setWebhook', [BotTelegramController::class, 'setWebhook']);
Route::post('ranggapbot/webhook', [BotTelegramController::class, 'commandHandlerWebhook']);
Route::get('/link-pdf/{chat_id}/{bulan}/{tahun}', [GajiController::class, 'urlPrintPDF'])->name('url-pdf');
Route::get('/print-pdf/{chat_id}/{bulan}/{tahun}', [GajiController::class, 'printPDF'])->name('print-pdf');
