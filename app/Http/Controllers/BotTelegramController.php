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

        // Periksa jika perintah adalah /slip
        elseif (strtolower($message->getText()) === '/slip') {
            $this->slipCommandHandler($chat_id);
        }

        // Periksa jika pesan adalah callback query
        elseif ($callback = $updates->getCallbackQuery()) {
            $this->handleCallbackQuery($callback);
        }

        return response()->json(['status' => 'ok']);
    }

    private function slipCommandHandler($chat_id)
    {
        // Daftar nama bulan
        $bulan = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        // Mendapatkan tahun sekarang
        $tahun_sekarang = date('Y');

        // Daftar tahun, misalnya dari tahun sekarang hingga dua tahun sebelumnya dan dua tahun berikutnya
        $tahun = range($tahun_sekarang - 2, $tahun_sekarang);

        // Menyusun tombol untuk setiap bulan
        $inline_keyboard = [];
        $row = [];
        foreach ($bulan as $index => $nama_bulan) {
            // Menyusun callback data untuk pemilihan bulan dan tahun
            foreach ($tahun as $thn) {
                $callback_data = json_encode(['bulan' => ($index + 1), 'tahun' => $thn]);
                $row[] = ['text' => $nama_bulan . ' ' . $thn, 'callback_data' => $callback_data];
            }
            $inline_keyboard[] = $row;
            $row = [];
        }

        // Kirim pesan dengan tombol inline untuk bulan dan tahun
        Telegram::sendMessage([
            'chat_id' => $chat_id,
            'text' => 'Pilih Bulan dan Tahun:',
            'reply_markup' => json_encode([
                'inline_keyboard' => $inline_keyboard
            ])
        ]);
    }

    private function handleCallbackQuery($callback)
    {
        $message = $callback->getMessage();
        $chat_id = $message->getChat()->getId();
        $data = $callback->getData();

        // Pastikan callback data tidak null
        if ($data) {
            $callback_data = json_decode($data, true);

            // Periksa apakah callback data berisi informasi bulan dan tahun
            if (isset($callback_data['bulan']) && isset($callback_data['tahun'])) {
                $bulan = $callback_data['bulan'];
                $tahun = $callback_data['tahun'];

                // Buat URL PDF sesuai dengan bulan dan tahun yang dipilih
                $documentUrl = 'https://8b11-103-120-173-126.ngrok-free.app/api/download-pdf/' . $chat_id . '/' . $bulan . '/' . $tahun;

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
        }
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
