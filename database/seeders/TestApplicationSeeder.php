<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Application;
use App\Models\Service;
use App\Models\Rt;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestApplicationSeeder extends Seeder
{
    public function run()
    {
        // =============================================
        // 1. BUAT / AMBIL WARGA TEST
        // =============================================
        $warga = User::where('email', 'warga.test@example.com')->first();
        
        if (!$warga) {
            $rt = Rt::first();
            
            $warga = User::create([
                'name' => 'Warga Test',
                'email' => 'warga.test@example.com',
                'password' => Hash::make('password'),
                'role' => 'warga',
                'nik' => '7371010101900001',
                'tempat_lahir' => 'Parepare',
                'tanggal_lahir' => '1990-01-01',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Galung Maloang No. 1, Parepare',
                'agama' => 'Islam',
                'pekerjaan' => 'Wiraswasta',
                'nomor_hp' => '081234567890',
                'rt_id' => $rt->id ?? null,
            ]);
            
            $this->command->info('✅ Warga Test dibuat');
        }

        // =============================================
        // 2. AMBIL SEMUA JENIS SURAT
        // =============================================
        $services = Service::where('is_active', true)
            ->where('is_custom', false)
            ->get();

        if ($services->isEmpty()) {
            $this->command->error('❌ Tidak ada service. Jalankan ServiceSeeder dulu.');
            return;
        }

        // =============================================
        // 3. BUAT PENGAJUAN DENGAN STATUS IN_PROGRESS
        // =============================================
        $sampleData = [
            'keperluan' => 'Daftar kerja',
            'lama_tinggal' => '5',
            'penghasilan' => '5000000',
            'pekerjaan_orang_tua' => 'Petani',
            'jumlah_tanggungan' => '3',
            'jenis_usaha' => 'Toko Kelontong',
            'penghasilan_per_bulan' => '3000000',
            'lama_usaha' => '2',
            'alamat_usaha' => 'Jl. Pasar Sentral No. 5',
            'tanggal_acara' => '2026-09-01',
            'tempat' => 'Balai Desa',
            'jenis_acara' => 'Pernikahan',
            'hari_tanggal' => 'Minggu, 1 September 2026',
            'jam' => '10:00 WITA - Selesai',
            'jenis_usaha_bbm' => 'Pertanian',
            'jenis_alat' => 'Traktor',
            'jumlah_alat' => '1',
            'fungsi_alat' => 'Mengolah sawah',
            'bbm_jenis' => 'Solar',
            'jam_operasi' => '8',
            'konsumsi_bbm' => '20',
            'nomor_penyalur' => '7491172',
            'lokasi_penyalur' => 'Jl. Jend. Sudirman',
            'tujuan_surat' => 'Pernikahan',
            'tanggal_meninggal' => '2026-08-20',
            'tempat_meninggal' => 'RSUD Parepare',
            'penyebab' => 'Sakit',
            'nama_saksi' => 'Budi',
            'luas_tanah' => '200',
            'nomor_sppt' => '1234567890',
            'alamat_tanah' => 'Jl. Poros No. 10',
            'batas_utara' => 'Tanah Pak Ahmad',
            'batas_selatan' => 'Sungai',
            'batas_timur' => 'Jalan Raya',
            'batas_barat' => 'Kebun',
            'keperluan_skck' => 'Melamar pekerjaan',
            'alasan' => 'Daftar CPNS',
            'tujuan' => 'Melamar kerja',
            'anak_nama' => 'Kezya',
            'anak_tempat_lahir' => 'Jakarta',
            'anak_tanggal_lahir' => '2015-06-09',
            'anak_jenis_kelamin' => 'L',
            'anak_pekerjaan' => 'Pelajar',
            'anak_alamat' => 'Jalan Harapan',
        ];

        $counter = 1;
        foreach ($services as $service) {
            $data = $this->getDataForService($service->id, $sampleData);
            
            $application = Application::create([
                'user_id' => $warga->id,
                'rt_id' => $warga->rt_id,
                'service_id' => $service->id,
                'application_number' => 'REQ-TEST-' . date('Y-m') . '-' . str_pad($counter, 6, '0', STR_PAD_LEFT),
                'status' => 'in_progress',  // <-- SEMUA IN PROGRESS
                'data' => $data,
                'notes' => 'Test untuk ' . $service->name,
                'submitted_at' => now()->subDays(rand(1, 3)),
                'rt_approved_at' => now()->subDays(rand(1, 2)),
                'rt_approved_by' => $warga->rt_id,
                'staff_id' => 1, // Staff pertama
                'processed_at' => now()->subHours(rand(1, 12)),
            ]);

            $this->command->info("✅ #{$counter}: {$service->name} → in_progress");
            $counter++;
        }

        // =============================================
        // 4. PENGAJUAN CUSTOM "LAINNYA"
        // =============================================
        Application::create([
            'user_id' => $warga->id,
            'rt_id' => $warga->rt_id,
            'service_id' => null,
            'application_number' => 'REQ-TEST-' . date('Y-m') . '-' . str_pad($counter, 6, '0', STR_PAD_LEFT),
            'status' => 'in_progress',
            'data' => ['custom_service_name' => 'Surat Keterangan Beda Nama'],
            'notes' => 'Pengajuan jenis lain',
            'submitted_at' => now()->subDays(1),
            'rt_approved_at' => now()->subHours(6),
            'rt_approved_by' => $warga->rt_id,
            'staff_id' => 1,
            'processed_at' => now()->subHours(3),
        ]);

        $this->command->info("✅ #{$counter}: Lainnya → in_progress");

        // =============================================
        // 5. INFO
        // =============================================
        $this->command->info('🎉 Seeder selesai!');
        $this->command->info('📧 Login: warga.test@example.com');
        $this->command->info('🔑 Password: password');
        $this->command->info("📋 Total pengajuan IN PROGRESS: {$counter}");
        $this->command->info('');
        $this->command->info('🔹 Sekarang login sebagai STAFF, buka dashboard,');
        $this->command->info('🔹 Klik "Lanjutkan" pada pengajuan,');
        $this->command->info('🔹 Tulis isi surat → klik "Terbitkan Surat"');
        $this->command->info('🔹 Cek hasil PDF dan WhatsApp!');
    }

    private function getDataForService($serviceId, $sampleData)
    {
        $dataMap = [
            1 => ['keperluan' => 'Daftar kerja', 'lama_tinggal' => '5'],
            2 => ['penghasilan' => '5000000', 'pekerjaan_orang_tua' => 'Petani', 'jumlah_tanggungan' => '3', 'anak_nama' => 'Kezya', 'anak_tempat_lahir' => 'Jakarta', 'anak_tanggal_lahir' => '2015-06-09', 'anak_jenis_kelamin' => 'L', 'anak_pekerjaan' => 'Pelajar', 'anak_alamat' => 'Jalan Harapan'],
            3 => ['alasan' => 'Tidak mampu bekerja', 'penghasilan_keluarga' => '1000000', 'jumlah_tanggungan' => '4'],
            4 => ['jenis_usaha' => 'Toko Kelontong', 'penghasilan_per_bulan' => '3000000', 'lama_usaha' => '2', 'alamat_usaha' => 'Jl. Pasar Sentral No. 5'],
            5 => ['hari_tanggal' => 'Minggu, 1 September 2026', 'jam' => '10:00 WITA', 'tempat' => 'Balai Desa', 'jenis_acara' => 'Pernikahan'],
            6 => ['jenis_usaha' => 'Pertanian', 'jenis_alat' => 'Traktor', 'jumlah_alat' => '1', 'fungsi_alat' => 'Mengolah sawah', 'bbm_jenis' => 'Solar', 'jam_operasi' => '8', 'konsumsi_bbm' => '20', 'nomor_penyalur' => '7491172', 'lokasi_penyalur' => 'Jl. Jend. Sudirman'],
            7 => ['tujuan_surat' => 'Pernikahan'],
            8 => ['tanggal_meninggal' => '2026-08-20', 'tempat_meninggal' => 'RSUD Parepare', 'penyebab' => 'Sakit', 'nama_saksi' => 'Budi'],
            9 => ['luas_tanah' => '200', 'nomor_sppt' => '1234567890', 'alamat_tanah' => 'Jl. Poros No. 10', 'batas_utara' => 'Tanah Pak Ahmad', 'batas_selatan' => 'Sungai', 'batas_timur' => 'Jalan Raya', 'batas_barat' => 'Kebun'],
            10 => ['keperluan_skck' => 'Melamar pekerjaan', 'alasan' => 'Daftar CPNS'],
        ];

        return $dataMap[$serviceId] ?? $sampleData;
    }
}