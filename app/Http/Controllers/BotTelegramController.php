<?php

namespace App\Http\Controllers;

use App\Models\TelegramUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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

    public function resetWebhook()
    {
        // Hapus webhook yang ada
        $response = Telegram::removeWebhook();

        // Atur ulang webhook
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
            $this->saveUserToDatabase($chat_id, $firstName);

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

        // Mendapatkan tahun sekarang dan bulan sekarang
        $tahun_sekarang = date('Y');
        $bulan_sekarang = date('n'); // Mendapatkan bulan sekarang dalam bentuk angka (1-12)

        // Daftar tahun, misalnya dari tahun sekarang hingga 1 tahun sebelumnya dan dua tahun berikutnya
        $tahun = range($tahun_sekarang - 1, $tahun_sekarang);

        // Menyusun tombol untuk setiap bulan
        $inline_keyboard = [];
        foreach ($tahun as $thn) {
            foreach ($bulan as $index => $nama_bulan) {
                $bulan_angka = $index + 1;
                // Hanya tampilkan bulan hingga bulan sekarang (termasuk bulan sekarang)
                if ($thn < $tahun_sekarang || ($thn == $tahun_sekarang && $bulan_angka <= $bulan_sekarang)) {
                    $nama_bulan_tahun = $nama_bulan . ' ' . $thn;
                    // Tambahkan tanda bintang jika ini adalah bulan sekarang
                    if ($bulan_angka == $bulan_sekarang && $thn == $tahun_sekarang) {
                        $nama_bulan_tahun .= ' *';
                    }
                    // Menyusun callback data untuk pemilihan bulan dan tahun
                    $callback_data = json_encode(['bulan' => $bulan_angka, 'tahun' => $thn]);
                    // Tambahkan tombol ke dalam satu baris (row)
                    $inline_keyboard[] = ['text' => $nama_bulan_tahun, 'callback_data' => $callback_data];
                }
            }
        }

        // Pisahkan tombol-tombol menjadi beberapa baris sesuai keinginan
        $inline_keyboard = array_chunk($inline_keyboard, 2); // Ubah 4 sesuai keinginan (jumlah tombol per baris)

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



                // Panggil API untuk mengecek ketersediaan slip gaji
                $apiResponse = $this->checkSlipAvailability($chat_id, $bulan, $tahun);

                if ($apiResponse['status'] === 'success') {
                    // Kirim pesan pemberitahuan kepada pengguna
                    $response = Http::get('https://api.nuryazid.com/finatale/public/api/link-pdf/' . $chat_id . '/' . $bulan . '/' . $tahun);
                    $message = $response->json()['message'] ?? 'API tidak merespon dengan benar';

                    Telegram::sendMessage([
                        'chat_id' => $chat_id,
                        'text' => $message,
                    ]);
                    // Slip gaji tersedia, kirimkan file PDF
                    $documentUrl = $apiResponse['pdf_link'];
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
                } else {
                    // Slip gaji tidak tersedia, kirim pesan pemberitahuan
                    Telegram::sendMessage([
                        'chat_id' => $chat_id,
                        'text' => $apiResponse['message'],
                    ]);
                }
            }
        }
    }

    private function checkSlipAvailability($chat_id, $bulan, $tahun)
    {
        $apiUrl = route('url-pdf', ['chat_id' => $chat_id, 'bulan' => $bulan, 'tahun' => $tahun]);
        $response = @file_get_contents($apiUrl);

        if ($response === FALSE) {
            $http_response_header = isset($http_response_header) ? $http_response_header : [];
            foreach ($http_response_header as $header) {
                if (strpos($header, '404') !== false) {
                    return [
                        'status' => 'error',
                        'message' => 'Slip gaji yang diminta belum tersedia',
                    ];
                }
            }
            return [
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memeriksa slip gaji',
            ];
        }

        return json_decode($response, true);
    }

    private function saveUserToDatabase($chat_id, $firstName)
    {
        // Cek apakah pengguna sudah ada di database
        $user = TelegramUser::where('chat_id', $chat_id)->first();

        // Jika tidak, simpan informasi pengguna ke dalam database
        if (!$user) {
            TelegramUser::create([
                'chat_id' => $chat_id,
                'username' => $firstName,
                // Tambahkan kolom lain yang ingin Anda simpan
            ]);
        }
    }
}
