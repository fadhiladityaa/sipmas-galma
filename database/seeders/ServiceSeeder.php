<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        $services = [
            // 1. Surat Keterangan Domisili
            [
                'name' => 'Surat Keterangan Domisili',
                'description' => 'Untuk keperluan domisili tempat tinggal',
                'fields' => json_encode([
                    ['name' => 'keperluan', 'label' => 'Keperluan Domisili', 'type' => 'text', 'required' => true],
                    ['name' => 'lama_tinggal', 'label' => 'Lama Tinggal (tahun)', 'type' => 'number', 'required' => false],
                ]),
            ],

            // 2. Surat Keterangan Penghasilan Orang Tua
            [
                'name' => 'Surat Keterangan Penghasilan Orang Tua',
                'description' => 'Untuk keperluan beasiswa atau bantuan (data orang tua dan anak)',
                'fields' => json_encode([
                    // Data Orang Tua (pemohon)
                    ['name' => 'penghasilan', 'label' => 'Penghasilan Orang Tua (Rp)', 'type' => 'number', 'required' => true],
                    ['name' => 'pekerjaan_orang_tua', 'label' => 'Pekerjaan Orang Tua', 'type' => 'text', 'required' => true],
                    ['name' => 'jumlah_tanggungan', 'label' => 'Jumlah Tanggungan', 'type' => 'number', 'required' => false],
                    // Data Anak
                    ['name' => 'anak_nama', 'label' => 'Nama Anak', 'type' => 'text', 'required' => true],
                    ['name' => 'anak_tempat_lahir', 'label' => 'Tempat Lahir Anak', 'type' => 'text', 'required' => true],
                    ['name' => 'anak_tanggal_lahir', 'label' => 'Tanggal Lahir Anak', 'type' => 'date', 'required' => true],
                    ['name' => 'anak_jenis_kelamin', 'label' => 'Jenis Kelamin Anak', 'type' => 'select', 'options' => ['L' => 'Laki-laki', 'P' => 'Perempuan'], 'required' => true],
                    ['name' => 'anak_pekerjaan', 'label' => 'Pekerjaan Anak', 'type' => 'text', 'required' => true],
                    ['name' => 'anak_alamat', 'label' => 'Alamat Anak', 'type' => 'textarea', 'required' => false],
                ]),
            ],

            // 3. Surat Keterangan Tidak Mampu
            [
                'name' => 'Surat Keterangan Tidak Mampu',
                'description' => 'Untuk keperluan bantuan sosial',
                'fields' => json_encode([
                    ['name' => 'alasan', 'label' => 'Alasan Keterangan Tidak Mampu', 'type' => 'textarea', 'required' => true],
                    ['name' => 'penghasilan_keluarga', 'label' => 'Penghasilan Keluarga per Bulan (Rp)', 'type' => 'number', 'required' => true],
                    ['name' => 'jumlah_tanggungan', 'label' => 'Jumlah Tanggungan Keluarga', 'type' => 'number', 'required' => false],
                ]),
            ],

            // 4. Surat Keterangan Usaha/Penghasilan
            [
                'name' => 'Surat Keterangan Usaha/Penghasilan',
                'description' => 'Untuk keperluan perbankan atau perizinan',
                'fields' => json_encode([
                    ['name' => 'jenis_usaha', 'label' => 'Jenis Usaha', 'type' => 'text', 'required' => true],
                    ['name' => 'penghasilan_per_bulan', 'label' => 'Penghasilan per Bulan (Rp)', 'type' => 'number', 'required' => true],
                    ['name' => 'lama_usaha', 'label' => 'Lama Usaha (tahun)', 'type' => 'number', 'required' => false],
                    ['name' => 'alamat_usaha', 'label' => 'Alamat Usaha', 'type' => 'text', 'required' => false],
                ]),
            ],

           // 5. Surat Pengantar Izin Keramaian
            [
                'name' => 'Surat Pengantar Izin Keramaian',
                'description' => 'Untuk mengajukan izin acara keramaian',
                'fields' => json_encode([
                    ['name' => 'hari_tanggal', 'label' => 'Hari/Tanggal Acara', 'type' => 'text', 'required' => true],
                    ['name' => 'jam', 'label' => 'Jam Acara. Cth. 08:00 WITA - Selesai', 'type' => 'text', 'required' => true],
                    ['name' => 'tempat', 'label' => 'Tempat Acara', 'type' => 'text', 'required' => true],
                    ['name' => 'jenis_acara', 'label' => 'Jenis Acara', 'type' => 'text', 'required' => false],
                ]),
            ],

            // 6. Surat Rekomendasi BBM Bersubsidi
            [
                'name' => 'Surat Rekomendasi BBM Bersubsidi',
                'description' => 'Untuk keperluan BBM bersubsidi',
                'fields' => json_encode([
                    ['name' => 'jenis_usaha', 'label' => 'Jenis Usaha/Kegiatan', 'type' => 'text', 'required' => true],
                    ['name' => 'jenis_alat', 'label' => 'Jenis Alat', 'type' => 'text', 'required' => true],
                    ['name' => 'jumlah_alat', 'label' => 'Jumlah Alat', 'type' => 'number', 'required' => true],
                    ['name' => 'fungsi_alat', 'label' => 'Fungsi Alat', 'type' => 'text', 'required' => true],
                    ['name' => 'bbm_jenis', 'label' => 'BBM Jenis Tertentu', 'type' => 'text', 'required' => true],
                    ['name' => 'jam_operasi', 'label' => 'Jam Operasi/Hari', 'type' => 'number', 'required' => true],
                    ['name' => 'konsumsi_bbm', 'label' => 'Konsumsi BBM (Liter/Hari)', 'type' => 'number', 'required' => true],
                    ['name' => 'nomor_penyalur', 'label' => 'Nomor Lembaga Penyalur', 'type' => 'text', 'required' => false],
                    ['name' => 'lokasi_penyalur', 'label' => 'Lokasi Penyalur', 'type' => 'text', 'required' => false],
                ]),
            ],

            // 7. Surat Keterangan Belum Menikah
            [
                'name' => 'Surat Keterangan Belum Menikah',
                'description' => 'Untuk keperluan pernikahan atau administrasi',
                'fields' => json_encode([
                    ['name' => 'tujuan_surat', 'label' => 'Tujuan Pembuatan Surat', 'type' => 'text', 'required' => true],
                ]),
            ],

            // 8. Surat Keterangan Kematian
            [
                'name' => 'Surat Keterangan Kematian',
                'description' => 'Untuk keperluan administrasi kematian',
                'fields' => json_encode([
                    ['name' => 'tanggal_meninggal', 'label' => 'Tanggal Meninggal', 'type' => 'date', 'required' => true],
                    ['name' => 'tempat_meninggal', 'label' => 'Tempat Meninggal', 'type' => 'text', 'required' => true],
                    ['name' => 'penyebab', 'label' => 'Penyebab Kematian', 'type' => 'text', 'required' => false],
                    ['name' => 'nama_saksi', 'label' => 'Nama Saksi', 'type' => 'text', 'required' => false],
                ]),
            ],

            // 9. Surat Keterangan Tanah Tidak Sengketa
            [
                'name' => 'Surat Keterangan Tanah Tidak Sengketa',
                'description' => 'Untuk keperluan jual beli atau perizinan tanah',
                'fields' => json_encode([
                    ['name' => 'luas_tanah', 'label' => 'Luas Tanah (m²)', 'type' => 'number', 'required' => true],
                    ['name' => 'nomor_sppt', 'label' => 'Nomor SPPT', 'type' => 'text', 'required' => true],
                    ['name' => 'alamat_tanah', 'label' => 'Alamat Tanah', 'type' => 'text', 'required' => true],
                    ['name' => 'batas_utara', 'label' => 'Batas Utara', 'type' => 'text', 'required' => false],
                    ['name' => 'batas_selatan', 'label' => 'Batas Selatan', 'type' => 'text', 'required' => false],
                    ['name' => 'batas_timur', 'label' => 'Batas Timur', 'type' => 'text', 'required' => false],
                    ['name' => 'batas_barat', 'label' => 'Batas Barat', 'type' => 'text', 'required' => false],
                ]),
            ],

            // 10. Surat Pengantar SKCK
            [
                'name' => 'Surat Pengantar SKCK',
                'description' => 'Untuk mengajukan SKCK ke Polri',
                'fields' => json_encode([
                    ['name' => 'keperluan_skck', 'label' => 'Keperluan SKCK', 'type' => 'text', 'required' => true],
                    ['name' => 'alasan', 'label' => 'Alasan Pengajuan SKCK', 'type' => 'textarea', 'required' => false],
                ]),
            ],
        ];

        foreach ($services as $s) {
            // Cek apakah service sudah ada, jika sudah update, jika belum create
            Service::updateOrCreate(
                ['name' => $s['name']],
                $s
            );
        }
    }
}