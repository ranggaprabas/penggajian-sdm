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
        $title = "Broadcast Information";
        $broadcasts = BroadcastInformation::select('broadcast_information.*', 'log_activities.action', 'log_activities.date_created as last_update', 'users.nama as username', 'sdms.nama as sdm_name', 'broadcast_information.category_id')
            ->leftJoin('log_activities', function ($join) {
                $join->on('log_activities.row_id', '=', 'broadcast_information.id')
                    ->where('log_activities.table_name', '=', 'broadcast_information')
                    ->whereRaw('log_activities.id = (SELECT MAX(id) FROM log_activities WHERE log_activities.row_id = broadcast_information.id AND log_activities.table_name = "broadcast_information")');
            })
            ->leftJoin('users', 'users.id', '=', 'log_activities.user_id')
            ->leftJoin('sdms', 'sdms.id', '=', 'broadcast_information.category_id')
            ->with('sdm')
            ->get();

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

        // Ambil hanya SDM yang memiliki chat_id tidak kosong
        $broadcasts = Sdm::select('id', 'nama')
            ->whereNotNull('chat_id')  // Filter untuk chat_id tidak null
            ->get();

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

    private function sendTelegramMessage($username, $message)
    {
        // Check if TELEGRAM_BOT_TOKEN is set
        $telegramSetting = Setting::where('telegram_bot_token', '!=', '')->first();
        if (!$telegramSetting) {
            // Token not set, log an error or handle as needed
            \Log::error('Telegram Bot Token not configured. Message not sent to ' . $username);
            return;
        }
        // Periksa apakah pesannya kosong
        if (empty(trim($message))) {
            \Log::error('Pesan kosong.');
            return;
        }

        // Hapus tag HTML yang tidak diinginkan
        $allowedTags = '<b><strong><i><em><u><ins><s><strike><del><span><a><tg-emoji><code><pre>';
        $message = strip_tags($message, $allowedTags);
        $message = str_replace('&nbsp;', ' ', $message);

        $response = Telegram::sendMessage([
            'chat_id' => $username,
            'text' => $message,
            'parse_mode' => 'HTML'
        ]);

        if ($response->isOk()) {
            // Pesan berhasil dikirim
            \Log::info('Pesan berhasil dikirim ke ' . $username);
        } else {
            // Tangani kesalahan
            // Catat atau beri tahu admin tentang kegagalan
            \Log::error('Gagal mengirim pesan Telegram ke ' . $username . ': ' . $response->getDescription());
        }
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
        $pages = 'Broadcast Information';
        $title = 'Detail Broadcast Information';

        $relatedBroadcasts = BroadcastInformation::select('broadcast_information.message', 'sdms.nama as sdm_name')
            ->leftJoin('sdms', 'sdms.id', '=', 'broadcast_information.category_id')
            ->where('broadcast_information.message', $broadcast->message)
            ->get();

        return view('admin.broadcast-information.show', compact('broadcast', 'relatedBroadcasts', 'pages', 'title'));
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
