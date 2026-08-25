<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        // Data Lurah (default)
        Setting::set('lurah_name', 'EKA SISWANTO PRATAMA, S.ST');
        Setting::set('lurah_pangkat', 'Penata TK. I/III.d');
        Setting::set('lurah_nip', '19850915 200804 1001');

        // Barcode (default kosong, nanti diupload admin)
        Setting::set('barcode_image', '', 'image');
        
        // Kop surat
        Setting::set('kop_alamat', 'Jalan Cendrawasih Kompleks Perumahan PNS');
        Setting::set('kop_telepon', '(0421) ... ... ... ... ... .....');
        Setting::set('kop_kota', 'PAREPARE');
        Setting::set('kop_kode_pos', 'Kode Pos 91125');
    }
}