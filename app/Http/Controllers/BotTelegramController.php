<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram;

class BotTelegramController extends Controller
{
    //
    public function setWebhook()
    {
        $response = Telegram::setWebhook(['url' => env('TELEGRAM_WEBHOOK_URL')]);

        if ($response === true) {
            // Webhook berhasil diatur, tetapi kita ingin menampilkan halaman 404.
            abort(404);
        }

        // Jika Anda ingin melakukan sesuatu setelah menetapkan webhook, tambahkan di sini.
        // ...

        // Respon seharusnya tidak pernah sampai ke sini jika webhook berhasil diatur.
        dd($response);
    }


    public function commandHandlerWebhook()
    {
        $updates = Telegram::commandsHandler(true);
        $chat_id = $updates->getChat()->getId();
        $username = $updates->getChat()->getFirstName();

        if (strtolower($updates->getMessage()->getText() === 'halo')) return Telegram::sendMessage([
            'chat_id' => $chat_id,
            'text' => 'Halo ' . $username
        ]);
    }
}
