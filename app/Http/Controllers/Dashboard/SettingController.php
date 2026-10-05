<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Menampilkan halaman form pengaturan.
     */
    public function index()
    {
        $settings = Setting::pluck('value', 'key');

        return view('dashboard.settings.index', [
            'settings' => $settings
        ]);
    }

    /**
     * Update data pengaturan di database.
     */
    public function update(Request $request)
    {
        // ===================================
        // PENYESUAIAN VALIDASI
        // ===================================
        $request->validate([
            // Pengaturan Umum
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'video_url' => 'nullable|url',

            // Pengaturan 'About'
            'about_title' => 'nullable|string|max:255',
            'about_subtitle' => 'nullable|string|max:255',
            'about_description' => 'nullable|string',
            'about_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',

            // Pengaturan Visi & Misi
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',

            // Pengaturan Statistik
            'stat_activities' => 'nullable|numeric',
            'stat_members' => 'nullable|numeric',
            'stat_programs' => 'nullable|numeric',
            'stat_partners' => 'nullable|numeric',
        ]);

        // 1. LOGIKA UPLOAD LOGO
        if ($request->hasFile('logo')) {
            if ($request->oldLogo) {
                Storage::disk('public')->delete($request->oldLogo);
            }
            $logoPath = $request->file('logo')->store('logos', 'public');
            Setting::updateOrCreate(
                ['key' => 'logo_path'],
                ['value' => $logoPath]
            );
        }

        // ===================================
        // 2. LOGIKA UPLOAD GAMBAR 'ABOUT' (BARU)
        // ===================================
        if ($request->hasFile('about_image')) {
            if ($request->old_about_image) {
                Storage::disk('public')->delete($request->old_about_image);
            }
            $aboutImagePath = $request->file('about_image')->store('settings', 'public');
            Setting::updateOrCreate(
                ['key' => 'about_image'],
                ['value' => $aboutImagePath]
            );
        }

        // ===================================
        // 3. SIMPAN SEMUA PENGATURAN LAINNYA
        // ===================================

        // Data yang akan disimpan
        $settingsData = [
            'video_url' => $request->input('video_url'),
            'visi' => $request->input('visi'),
            'misi' => $request->input('misi'),
            'about_title' => $request->input('about_title'),
            'about_subtitle' => $request->input('about_subtitle'),
            'about_description' => $request->input('about_description'),
            'stat_activities' => $request->input('stat_activities'),
            'stat_members' => $request->input('stat_members'),
            'stat_programs' => $request->input('stat_programs'),
            'stat_partners' => $request->input('stat_partners'),
        ];

        // Loop dan simpan
        foreach ($settingsData as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        // Kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Pengaturan berhasil diperbarui!');
    }
}
