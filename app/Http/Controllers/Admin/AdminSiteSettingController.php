<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminSiteSettingController extends Controller
{
    public function index()
    {
        // Seed default settings jika belum ada
        $defaults = [
            ['key' => 'hero_image',    'label' => 'Hero Background Image', 'type' => 'image'],
            ['key' => 'hero_title',    'label' => 'Hero Title',             'type' => 'text',  'value' => 'Booking Pendakian Gunung Impian Anda'],
            ['key' => 'hero_subtitle', 'label' => 'Hero Subtitle',          'type' => 'text',  'value' => 'Temukan jalur terbaik dari seluruh gunung di Pulau Jawa.'],
        ];

        foreach ($defaults as $d) {
            SiteSetting::firstOrCreate(
                ['key' => $d['key']],
                ['label' => $d['label'], 'type' => $d['type'], 'value' => $d['value'] ?? null]
            );
        }

        $settings = SiteSetting::all()->keyBy('key');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'hero_image'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'hero_title'    => 'nullable|string|max:255',
            'hero_subtitle' => 'nullable|string|max:500',
        ]);

        // Handle hero image upload
        if ($request->hasFile('hero_image')) {
            // Hapus file lama jika ada
            $old = SiteSetting::get('hero_image');
            if ($old && Storage::disk('public')->exists($old)) {
                Storage::disk('public')->delete($old);
            }

            $path = $request->file('hero_image')->storeAs(
                'gunung/hero',
                'hero-gunung.' . $request->file('hero_image')->extension(),
                'public'
            );
            SiteSetting::set('hero_image', $path);
        }

        // Handle text settings
        if ($request->filled('hero_title')) {
            SiteSetting::set('hero_title', $request->hero_title);
        }

        if ($request->filled('hero_subtitle')) {
            SiteSetting::set('hero_subtitle', $request->hero_subtitle);
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Pengaturan beranda berhasil disimpan.');
    }
}
