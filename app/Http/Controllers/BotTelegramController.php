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
        // Periksa jika perintah adalah /file
        if (strtolower($message->getText()) === '/file') {
            // Kirim file PDF kepada pengguna
            $documentUrl = 'https://files1.simpkb.id/guruberbagi/rpp/427181-1673150322.pdf'; // URL file PDF yang ingin dikirim
            $botToken = env('TELEGRAM_BOT_TOKEN');
            $url = "https://api.telegram.org/bot{$botToken}/sendDocument?chat_id={$chat_id}&document={$documentUrl}";
            $response = file_get_contents($url);
            $response = json_decode($response, true);

            if ($response['ok']) {
                // Pesan berhasil dikirim
                // Lakukan sesuatu di sini jika diperlukan
            } else {
                // Pesan gagal dikirim
                // Lakukan sesuatu di sini jika diperlukan
            }
        }

        // Periksa jika perintah adalah /slip
        if (strtolower($message->getText()) === '/slip') {
            // Kirim keyboard inline dengan pilihan bulan dan tahun
            Telegram::sendMessage([
                'chat_id' => $chat_id,
                'text' => 'Pilih bulan dan tahun:',
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            ['text' => 'Januari 2024', 'callback_data' => '1/2024'],
                            ['text' => 'Februari 2024', 'callback_data' => '2/2024'],
                            // Tambahkan pilihan bulan dan tahun lainnya sesuai kebutuhan
                        ],
                    ],
                ]),
            ]);
        }

        // Lakukan pemrosesan callback jika ada
        if ($updates->getCallbackQuery()) {
            $callbackData = $updates->getCallbackQuery()->getData();

            // Pisahkan bulan dan tahun dari callback data
            list($bulan, $tahun) = explode('/', $callbackData);

            // Buat link untuk mengakses PDF menggunakan data bulan dan tahun yang dipilih
            $pdfLink = route('url-pdf', ['chat_id' => $chat_id, 'bulan' => $bulan, 'tahun' => $tahun]);

            // Respon langsung kepada pengguna dengan tautan PDF
            Telegram::sendMessage([
                'chat_id' => $chat_id,
                'text' => $pdfLink,
            ]);
        }

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
