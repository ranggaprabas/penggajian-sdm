<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function show()
    {
        $setting = Setting::firstOrNew(); // Use firstOrNew to create a new instance if no record is found
        $user = Auth::user(); // Get the authenticated user

        // Check if the user has an associated Entitas
        if ($user->entitas) {
            $entitas = $user->entitas;
        } else {
            $entitas = null;
        }

        return view('admin.settings.show', compact('setting', 'entitas'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $setting = Setting::firstOrNew();

        // Simpan nilai lama Telegram Bot Token
        $oldTelegramBotToken = $setting->telegram_bot_token;

        // Validasi untuk Telegram Bot Token
        $request->validate([
            'telegram_bot_token' => ($user->status == 1) ? 'required' : '',
        ]);

        // Update the setting
        if ($user->status == 1) {
            $setting->telegram_bot_token = $request->input('telegram_bot_token');
            $setting->save();
        }

        // Update the entitas if available
        if ($user->entitas) {
            $entitas = $user->entitas;

            $validatedData = $request->validate([
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg,webp',
                'alamat' => 'required',
            ]);

            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                // Jika ada gambar baru yang diunggah, proses pembaruan gambar
                $imagePath = $request->file('image')->store('images/entitas', 'public');

                // Hapus gambar lama jika ada
                if ($entitas->image) {
                    Storage::disk('public')->delete($entitas->image);
                }

                // Simpan path gambar yang baru
                $validatedData['image'] = $imagePath;
            } else {
                // Jika tidak ada gambar baru yang diunggah, gunakan old image
                $validatedData['image'] = $entitas->image;
            }

            $entitas->update($validatedData);
        }

        return redirect()->route('admin.settings.show')->with([
            'success', 'Settings updated successfully.',
            'alert-info' => 'info'
        ])->withInput(['telegram_bot_token' => $oldTelegramBotToken]);
    }
}
