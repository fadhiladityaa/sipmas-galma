<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.settings');
    }

    public function update(Request $request)
    {
        $request->validate([
            'barcode_image' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'lurah_name' => 'nullable|string|max:255',
            'lurah_pangkat' => 'nullable|string|max:100',
            'lurah_nip' => 'nullable|string|max:50',
            'kop_alamat' => 'nullable|string|max:255',
            'kop_telepon' => 'nullable|string|max:50',
            'kop_kota' => 'nullable|string|max:100',
            'kop_kode_pos' => 'nullable|string|max:20',
        ]);

        // Upload Barcode
        if ($request->hasFile('barcode_image')) {
            $oldImage = Setting::get('barcode_image');
            if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                Storage::disk('public')->delete($oldImage);
            }

            $path = $request->file('barcode_image')->store('barcode', 'public');
            Setting::set('barcode_image', $path, 'image');
        }

        // Update data Lurah
        if ($request->filled('lurah_name')) {
            Setting::set('lurah_name', $request->lurah_name);
        }
        if ($request->filled('lurah_pangkat')) {
            Setting::set('lurah_pangkat', $request->lurah_pangkat);
        }
        if ($request->filled('lurah_nip')) {
            Setting::set('lurah_nip', $request->lurah_nip);
        }

        // Update kop surat
        if ($request->filled('kop_alamat')) {
            Setting::set('kop_alamat', $request->kop_alamat);
        }
        if ($request->filled('kop_telepon')) {
            Setting::set('kop_telepon', $request->kop_telepon);
        }
        if ($request->filled('kop_kota')) {
            Setting::set('kop_kota', $request->kop_kota);
        }
        if ($request->filled('kop_kode_pos')) {
            Setting::set('kop_kode_pos', $request->kop_kode_pos);
        }

        return redirect()->route('admin.settings')
            ->with('success', '✅ Pengaturan berhasil disimpan!');
    }
}