<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BroadcastInformation;
use App\Models\LogActivity;
use App\Models\Sdm;
use App\Models\Setting;
use Telegram;
use Illuminate\Support\HtmlString;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BroadcastInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get the TELEGRAM_BOT_TOKEN from the database
        $telegramSetting = Setting::where('telegram_bot_token', '!=', '')->first();

        // Check if TELEGRAM_BOT_TOKEN is set
        if (!$telegramSetting) {
            // Token not set, redirect to 404 or display an error
            abort(404, 'Telegram Bot Token not configured');
        }

        // Mendapatkan entitas admin yang sedang login
        $entitasAdmin = Auth::user()->entitas->id;
        // Mendapatkan status user yang sedang login
        $statusUser = Auth::user()->status;

        $title = "Broadcast Information";
        if ($statusUser == 1) {
            // Jika status user adalah 1, tidak mempertimbangkan entitas
            $broadcasts = BroadcastInformation::select('broadcast_information.*', 'log_activities.action', 'log_activities.date_created as last_update', 'users.nama as username', 'sdms.nama as sdm_name', 'broadcast_information.category_id', 'sdms.entitas_id')
                ->leftJoin('log_activities', function ($join) {
                    $join->on('log_activities.row_id', '=', 'broadcast_information.id')
                        ->where('log_activities.table_name', '=', 'broadcast_information')
                        ->whereRaw('log_activities.id = (SELECT MAX(id) FROM log_activities WHERE log_activities.row_id = broadcast_information.id AND log_activities.table_name = "broadcast_information")');
                })
                ->leftJoin('users', 'users.id', '=', 'log_activities.user_id')
                ->leftJoin('sdms', 'sdms.id', '=', 'broadcast_information.category_id')
                ->with('sdm')
                ->get();
        } else {
            // Jika status user bukan 1, pertimbangkan entitas
            $broadcasts = BroadcastInformation::select('broadcast_information.*', 'log_activities.action', 'log_activities.date_created as last_update', 'users.nama as username', 'sdms.nama as sdm_name', 'broadcast_information.category_id', 'sdms.entitas_id')
                ->leftJoin('log_activities', function ($join) {
                    $join->on('log_activities.row_id', '=', 'broadcast_information.id')
                        ->where('log_activities.table_name', '=', 'broadcast_information')
                        ->whereRaw('log_activities.id = (SELECT MAX(id) FROM log_activities WHERE log_activities.row_id = broadcast_information.id AND log_activities.table_name = "broadcast_information")');
                })
                ->leftJoin('users', 'users.id', '=', 'log_activities.user_id')
                ->leftJoin('sdms', 'sdms.id', '=', 'broadcast_information.category_id')
                ->where('sdms.entitas_id', $entitasAdmin)
                ->with('sdm')
                ->get();
        }

        // Inisialisasi array untuk menyimpan data yang akan ditampilkan
        $uniqueBroadcasts = [];

        // Iterasi melalui setiap broadcast
        foreach ($broadcasts as $broadcast) {
            // Cari apakah pesan ini sudah ditambahkan ke kategori yang sama
            $existingBroadcastKey = collect($uniqueBroadcasts)->search(function ($item) use ($broadcast) {
                return $item['message'] === $broadcast->message;
            });

            // Jika sudah ditambahkan, tambahkan data ke kategori yang sudah ada
            if ($existingBroadcastKey !== false) {
                $uniqueBroadcasts[$existingBroadcastKey]['sdm_names'][] = $broadcast->sdm_name;
            } else {
                // Jika belum ditambahkan, tambahkan kategori baru
                $uniqueBroadcasts[] = [
                    'id' => $broadcast->id,
                    'message' => $broadcast->message,
                    'last_update' => $broadcast->last_update,
                    'action' => $broadcast->action,
                    'username' => $broadcast->username,
                    'sdm_names' => [$broadcast->sdm_name],
                ];
            }
        }

        return view("admin.broadcast-information.index", compact('title', 'uniqueBroadcasts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get the TELEGRAM_BOT_TOKEN from the database
        $telegramSetting = Setting::where('telegram_bot_token', '!=', '')->first();

        // Check if TELEGRAM_BOT_TOKEN is set
        if (!$telegramSetting) {
            // Token not set, redirect to 404 or display an error
            abort(404, 'Telegram Bot Token not configured');
        }
        $title = 'Add Broadcast Information';
        $pages = "Broadcast Information";
        // Mendapatkan status user yang sedang login
        $statusUser = Auth::user()->status;

        if ($statusUser == 1) {
            // Jika status user adalah 1, tidak mempertimbangkan entitas
            $broadcasts = Sdm::select('id', 'nama')
                ->whereNotNull('chat_id')  // Filter untuk chat_id tidak null
                ->get();
        } else {
            // Jika status user bukan 1, pertimbangkan entitas
            // Mendapatkan entitas admin yang sedang login
            $entitasAdmin = Auth::user()->entitas->id;

            // Ambil hanya SDM yang memiliki chat_id tidak kosong dan terkait dengan entitas yang sedang login
            $broadcasts = Sdm::select('id', 'nama')
                ->whereNotNull('chat_id')  // Filter untuk chat_id tidak null
                ->where('entitas_id', $entitasAdmin)
                ->get();
        }

        return view('admin.broadcast-information.create', compact('pages', 'title', 'broadcasts'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'categories' => 'required|array',
            'message' => 'required|string',
        ]);

        foreach ($validatedData['categories'] as $categoryId) {
            $category = Sdm::find($categoryId);

            if ($category) {
                // Pastikan $category memiliki properti chat_id
                if (isset($category->chat_id)) {

                    $broadcastInfo = BroadcastInformation::create([
                        'category_id' => $categoryId,
                        'message' => $validatedData['message'], // Gunakan $validatedData['message']
                    ]);

                    // LogActivity
                    LogActivity::create([
                        'table_name' => 'broadcast_information',
                        'row_id' => $broadcastInfo->id,
                        'user_id' => auth()->user()->id,
                        'action' => 'add',
                        'date_created' => now()->format('Y-m-d H:i:s')
                    ]);

                    $this->sendTelegramMessage($category->chat_id, $validatedData['message']); // Gunakan $validatedData['message']
                } else {
                    // Jika chat_id tidak valid, berikan alert atau tindakan lain yang sesuai
                    return redirect()->route('admin.broadcast-information.index')
                        ->with('error', 'Chat ID tidak valid untuk kategori yang dipilih');
                }
            }
        }

        return redirect()->route('admin.broadcast-information.index')
            ->with('success', 'Broadcast Information berhasil dikirim');
    }

    private function sendTelegramMessage($chat_id, $message)
    {
        // Check if TELEGRAM_BOT_TOKEN is set
        $telegramSetting = Setting::where('telegram_bot_token', '!=', '')->first();
        if (!$telegramSetting) {
            // Token not set, log an error or handle as needed
            \Log::error('Telegram Bot Token not configured. Message not sent to ' . $chat_id);
            return;
        }

        // Periksa apakah pesannya kosong
        if (empty(trim($message))) {
            \Log::error('Pesan kosong.');
            return;
        }

        // Function to remove &nbsp; and format bold and italic text
        $message = $this->cleanAndFormatText($message);

        // Convert HTML to plain text
        $plainMessage = str_replace(['<p>', '</p>', '<br>', '<br/>', '<br />'], "\n", $message);
        $plainMessage = strip_tags($plainMessage);
        $plainMessage = preg_replace("/(\n\s*)+\n/", "\n", $plainMessage); // Remove extra new lines

        // Encode the message with Markdown V2 formatting
        $encodedMessage = urlencode($plainMessage);

        // Retrieve Telegram bot token from settings
        $telegramBotToken = $telegramSetting->telegram_bot_token;

        // Build URL to send message using Telegram API
        $url = "https://api.telegram.org/bot$telegramBotToken/sendMessage?chat_id=$chat_id&text=$encodedMessage&parse_mode=MarkdownV2";

        // Send HTTP request using cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // Check response and handle accordingly
        if ($httpCode == 200) {
            // Message sent successfully
            \Log::info('Pesan berhasil dikirim ke ' . $chat_id);
        } else {
            // Handle error
            // Log or notify admin about the failure
            \Log::error('Gagal mengirim pesan Telegram ke ' . $chat_id . ': ' . $response);
        }
    }

    // Function to remove &nbsp; and format bold and italic text
    private function cleanAndFormatText($message)
    {
        // Remove &nbsp; and replace with regular space
        $message = str_replace('&nbsp;', ' ', $message);

        // Detect <strong> tags and convert them to Markdown bold (* *)
        $message = preg_replace("/<strong>(.*?)<\/strong>/s", "*$1*", $message);

        // Detect <i> tags and convert them to Markdown italic (_ _)
        $message = preg_replace("/<i>(.*?)<\/i>/s", "_$1_", $message);

        // Detect text wrapped in asterisks and keep them as they are
        // Assuming they are already intended to be bold in Markdown
        $message = preg_replace("/\*(.*?)\*/s", "*$1*", $message);

        return $message;
    }



    public function show($id)
    {
        // Get the TELEGRAM_BOT_TOKEN from the database
        $telegramSetting = Setting::where('telegram_bot_token', '!=', '')->first();

        // Check if TELEGRAM_BOT_TOKEN is set
        if (!$telegramSetting) {
            // Token not set, redirect to 404 or display an error
            abort(404, 'Telegram Bot Token not configured');
        }

        $broadcast = BroadcastInformation::with('sdm')->findOrFail($id);
        $user = Auth::user();
        $entitasAdmin = $user->entitas->id;
        $statusUser = $user->status;

        // Jika status user adalah 1 atau entitas sesuai dengan user yang login, izinkan akses
        if ($statusUser == 1 || $broadcast->sdm->entitas_id == $entitasAdmin) {
            $pages = 'Broadcast Information';
            $title = 'Detail Broadcast Information';

            $relatedBroadcasts = BroadcastInformation::select('broadcast_information.message', 'sdms.nama as sdm_name')
                ->leftJoin('sdms', 'sdms.id', '=', 'broadcast_information.category_id')
                ->where('broadcast_information.message', $broadcast->message)
                ->get();

            return view('admin.broadcast-information.show', compact('broadcast', 'relatedBroadcasts', 'pages', 'title'));
        } else {
            // Tampilkan pesan atau arahkan ke halaman tertentu jika akses ditolak
            abort(404, 'Unauthorized access');
        }
    }

    /**
     * Store a newly created resource in storage.
     */




    /**
     * Show the form for editing the specified resource.
     */


    /**
     * Update the specified resource in storage.
     */


    /**
     * Remove the specified resource from storage.
     */
}
