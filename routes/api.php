<?php

use App\Http\Controllers\Admin\GajiController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('setWebhook', [BotTelegramController::class, 'setWebhook']);
Route::post('ranggapbot/webhook', [BotTelegramController::class, 'commandHandlerWebhook']);
Route::get('/link-pdf/{chat_id}/{bulan}/{tahun}', [GajiController::class, 'urlPrintPDF'])->name('url-pdf');
Route::get('/print-pdf/{chat_id}/{bulan}/{tahun}', [GajiController::class, 'printPDF']);
