<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BroadcastInformation;
use App\Models\LogActivity;
use App\Models\Sdm;
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
        $title = "Broadcast Information";
        $broadcasts = BroadcastInformation::select('broadcast_information.*', 'log_activities.action', 'log_activities.date_created as last_update', 'users.nama as username')
            ->leftJoin('log_activities', function ($join) {
                $join->on('log_activities.row_id', '=', 'broadcast_information.id')
                    ->where('log_activities.table_name', '=', 'broadcast_information')
                    ->whereRaw('log_activities.id = (SELECT MAX(id) FROM log_activities WHERE log_activities.row_id = broadcast_information.id AND log_activities.table_name = "broadcast_information")');
            })
            ->leftJoin('users', 'users.id', '=', 'log_activities.user_id')
            ->with('sdm')
            ->get();

        // Inisialisasi array untuk menyimpan data yang akan ditampilkan
        $uniqueBroadcasts = [];

        // Iterasi melalui setiap broadcast
        foreach ($broadcasts as $broadcast) {
            // Cari apakah pesan ini sudah ditambahkan
            $existingBroadcast = collect($uniqueBroadcasts)->firstWhere('message', $broadcast->message);

            // Jika belum ditambahkan, tambahkan
            if (!$existingBroadcast) {
                $uniqueBroadcasts[] = [
                    'message' => $broadcast->message,
                    'last_update' => $broadcast->last_update,
                    'action' => $broadcast->action,
                    'username' => $broadcast->username,
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
        $title = 'Add Broadcast Information';
        $pages = "Broadcast Information";
        $broadcasts = Sdm::get(['id', 'nama']);
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
                    // Strip HTML tags and decode HTML entities from the message
                    $message = new HtmlString((html_entity_decode($validatedData['message'])));

                    $broadcastInfo = BroadcastInformation::create([
                        'category_id' => $categoryId,
                        'message' => 'hai,<b>rangga</b>',
                    ]);

                    // LogActivity
                    LogActivity::create([
                        'table_name' => 'broadcast_information',
                        'row_id' => $broadcastInfo->id,
                        'user_id' => auth()->user()->id,
                        'action' => 'add',
                        'date_created' => now()->format('Y-m-d H:i:s')
                    ]);

                    $this->sendTelegramMessage($category->chat_id, $message);
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
        // Strip HTML tags and decode HTML entities from the message
        $plainTextMessage = (html_entity_decode($message));

        // Check if the message is empty after stripping HTML tags
        if (empty(trim($plainTextMessage))) {
            \Log::error('Message is empty after stripping HTML tags.');
            return;
        }

        $response = Telegram::sendMessage([
            'chat_id' => $username,
            'text' => 'hai, <b>hai</b> <i>hai italic</i>',
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


    /**
     * Store a newly created resource in storage.
     */


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

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
