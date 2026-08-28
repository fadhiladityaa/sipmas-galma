<?php

namespace Database\Seeders;

use App\Models\Rw;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RwSeeder extends Seeder
{
    public function run(): void
    {
        $rwData = [
            ['rw' => '001', 'name' => 'RW 001', 'email' => 'rw001@sipmas-galma.com'],
            ['rw' => '002', 'name' => 'RW 002', 'email' => 'rw002@sipmas-galma.com'],
            ['rw' => '003', 'name' => 'RW 003', 'email' => 'rw003@sipmas-galma.com'],
            ['rw' => '004', 'name' => 'RW 004', 'email' => 'rw004@sipmas-galma.com'],
            ['rw' => '005', 'name' => 'RW 005', 'email' => 'rw005@sipmas-galma.com'],
            ['rw' => '006', 'name' => 'RW 006', 'email' => 'rw006@sipmas-galma.com'],
            ['rw' => '007', 'name' => 'RW 007', 'email' => 'rw007@sipmas-galma.com'],
            ['rw' => '008', 'name' => 'RW 008', 'email' => 'rw008@sipmas-galma.com'],
            ['rw' => '009', 'name' => 'RW 009', 'email' => 'rw009@sipmas-galma.com'],
        ];

        foreach ($rwData as $data) {

            // 1. Cari atau buat akun User RW
            $user = User::firstOrCreate(
                [
                    'email' => $data['email'],
                ],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('password'),
                    'role' => 'rw',
                ]
            );

            // 2. Cari atau buat data RW
            $rw = Rw::firstOrCreate(
                [
                    'user_id' => $user->id,
                ],
                [
                    'rw_number' => $data['rw'],
                    'alamat' => 'Kelurahan Galung Maloang, Kecamatan Bacukiki, Kota Parepare',
                    'phone_number' => null,
                    'is_active' => true,
                ]
            );

            // 3. Hubungkan User dengan RW
            $user->rw_id = $rw->id;
            $user->save();
        }

        $this->command->info('✅ ' . count($rwData) . ' akun RW berhasil dibuat/diperbarui.');
        $this->command->info('✅ Semua akun RW sudah terhubung dengan rw_id.');
        $this->command->info('🔑 Password: password');
    }
}