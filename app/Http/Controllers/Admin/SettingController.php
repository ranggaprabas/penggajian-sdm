<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    //
    public function show()
    {
        $setting = Setting::first();
        return view('admin.settings.show', compact('setting'));
    }

    public function edit()
    {
        $setting = Setting::firstOrNew(); // Use firstOrNew to create a new instance if no record is found
        return view('admin.settings.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'telegram_bot_token' => 'required',
        ]);

        $setting = Setting::firstOrNew(); // Use firstOrNew to create a new instance if no record is found
        $setting->telegram_bot_token = $request->input('telegram_bot_token');
        $setting->save();

        return redirect()->route('admin.settings.show')->with([
            'success', 'Settings updated successfully.',
            'alert-info' => 'info'
        ]);
    }
}
