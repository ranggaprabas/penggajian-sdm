<?php

namespace App\Http\Controllers;

use App\Models\TelegramUser;
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
        $message = $updates->getMessage();
        $chat_id = $message->getChat()->getId();
        $username = $message->getChat()->getUsername();
        $firstName = $message->getChat()->getFirstName(); 

        // Periksa jika perintah adalah /start
        if (strtolower($message->getText()) === '/start') {
            // Simpan informasi pengguna ke dalam database
            $this->saveUserToDatabase($chat_id, $username);

            // Respon kepada pengguna
            Telegram::sendMessage([
                'chat_id' => $chat_id,
                'text' => 'Hi ' . $firstName . ', salam kenal. Bagaimana kabarmu?',
            ]);
        }

        // Lanjutkan dengan pemrosesan lebih lanjut jika diperlukan
        // ...

        return response()->json(['status' => 'ok']);
    }

    private function saveUserToDatabase($chat_id, $username)
    {
        // Cek apakah pengguna sudah ada di database
        $user = TelegramUser::where('chat_id', $chat_id)->first();

        // Jika tidak, simpan informasi pengguna ke dalam database
        if (!$user) {
            TelegramUser::create([
                'chat_id' => $chat_id,
                'username' => $username,
                // Tambahkan kolom lain yang ingin Anda simpan
            ]);
        }
    }
}
