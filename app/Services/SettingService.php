<?php

namespace App\Services;

use App\Models\Setting;

class SettingService
{
    public function getLurahData()
    {
        return [
            'nama' => Setting::get('lurah_name', 'MUHAMMAD ZULKIFLI FARID, SE'),
            'pangkat' => Setting::get('lurah_pangkat', 'Penata TK. I'),
            'nip' => Setting::get('lurah_nip', '19841202 200801 1 003'),
        ];
    }

    public function getBarcodeImage()
    {
        $path = Setting::get('barcode_image');
        if ($path && \Storage::disk('public')->exists($path)) {
            return asset('storage/' . $path);
        }
        return null;
    }

    public function hasBarcode()
    {
        return !empty($this->getBarcodeImage());
    }
}