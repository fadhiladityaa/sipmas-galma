<?php

namespace Database\Seeders;

use App\Models\Rt;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RtSeeder extends Seeder
{
    public function run(): void
    {
        $rtData = [
            // RW 001 (2 RT)
            ['rw' => '001', 'rt' => '001', 'name' => 'RT 001 RW 001', 'email' => 'rt001.rw001@sipmas-galma.com'],
            ['rw' => '001', 'rt' => '002', 'name' => 'RT 002 RW 001', 'email' => 'rt002.rw001@sipmas-galma.com'],
            
            // RW 002 (2 RT)
            ['rw' => '002', 'rt' => '001', 'name' => 'RT 001 RW 002', 'email' => 'rt001.rw002@sipmas-galma.com'],
            ['rw' => '002', 'rt' => '002', 'name' => 'RT 002 RW 002', 'email' => 'rt002.rw002@sipmas-galma.com'],
            
            // RW 003 (2 RT)
            ['rw' => '003', 'rt' => '001', 'name' => 'RT 001 RW 003', 'email' => 'rt001.rw003@sipmas-galma.com'],
            ['rw' => '003', 'rt' => '002', 'name' => 'RT 002 RW 003', 'email' => 'rt002.rw003@sipmas-galma.com'],
            
            // RW 004 (2 RT)
            ['rw' => '004', 'rt' => '001', 'name' => 'RT 001 RW 004', 'email' => 'rt001.rw004@sipmas-galma.com'],
            ['rw' => '004', 'rt' => '002', 'name' => 'RT 002 RW 004', 'email' => 'rt002.rw004@sipmas-galma.com'],
            
            // RW 005 (2 RT)
            ['rw' => '005', 'rt' => '001', 'name' => 'RT 001 RW 005', 'email' => 'rt001.rw005@sipmas-galma.com'],
            ['rw' => '005', 'rt' => '002', 'name' => 'RT 002 RW 005', 'email' => 'rt002.rw005@sipmas-galma.com'],
            
            // =============================================
            // RW 006 (4 RT: 001, 002, 003, 004)
            // =============================================
            ['rw' => '006', 'rt' => '001', 'name' => 'RT 001 RW 006', 'email' => 'rt001.rw006@sipmas-galma.com'],
            ['rw' => '006', 'rt' => '002', 'name' => 'RT 002 RW 006', 'email' => 'rt002.rw006@sipmas-galma.com'],
            ['rw' => '006', 'rt' => '003', 'name' => 'RT 003 RW 006', 'email' => 'rt003.rw006@sipmas-galma.com'],
            ['rw' => '006', 'rt' => '004', 'name' => 'RT 004 RW 006', 'email' => 'rt004.rw006@sipmas-galma.com'],
            
            // RW 007 (2 RT)
            ['rw' => '007', 'rt' => '001', 'name' => 'RT 001 RW 007', 'email' => 'rt001.rw007@sipmas-galma.com'],
            ['rw' => '007', 'rt' => '002', 'name' => 'RT 002 RW 007', 'email' => 'rt002.rw007@sipmas-galma.com'],
            
            // =============================================
            // RW 008 (4 RT: 001, 002, 003, 004)
            // =============================================
            ['rw' => '008', 'rt' => '001', 'name' => 'RT 001 RW 008', 'email' => 'rt001.rw008@sipmas-galma.com'],
            ['rw' => '008', 'rt' => '002', 'name' => 'RT 002 RW 008', 'email' => 'rt002.rw008@sipmas-galma.com'],
            ['rw' => '008', 'rt' => '003', 'name' => 'RT 003 RW 008', 'email' => 'rt003.rw008@sipmas-galma.com'],
            ['rw' => '008', 'rt' => '004', 'name' => 'RT 004 RW 008', 'email' => 'rt004.rw008@sipmas-galma.com'],
            
            // RW 009 (2 RT)
            ['rw' => '009', 'rt' => '001', 'name' => 'RT 001 RW 009', 'email' => 'rt001.rw009@sipmas-galma.com'],
            ['rw' => '009', 'rt' => '002', 'name' => 'RT 002 RW 009', 'email' => 'rt002.rw009@sipmas-galma.com'],
        ];

        foreach ($rtData as $data) {
            // Buat User
            $user = User::where('email', $data['email'])->first();
            
            if (!$user) {
                $user = User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => Hash::make('password'),
                    'role' => 'rt',
                ]);
            }

            // Buat Rt
            $rt = Rt::where('user_id', $user->id)->first();
            if (!$rt) {
                $rt = Rt::create([
                    'user_id' => $user->id,
                    'rt_number' => $data['rt'],
                    'rw_number' => $data['rw'],
                    'alamat' => 'Kelurahan Galung Maloang, Kecamatan Bacukiki, Kota Parepare',
                    'phone_number' => null,
                    'is_active' => true,
                ]);
            }
            
            // Update rt_id di user
            if ($user->rt_id !== $rt->id) {
                $user->rt_id = $rt->id;
                $user->save();
            }
        }

        $this->command->info('✅ ' . count($rtData) . ' akun RT berhasil dibuat!');
        $this->command->info('📧 Email: rt001.rw001@sipmas-galma.com - rt002.rw009@sipmas-galma.com');
        $this->command->info('🔑 Password: password');
        $this->command->info('');
        $this->command->info('📋 Detail:');
        $this->command->info('   - RW 001-005, 007, 009: 2 RT (total 14)');
        $this->command->info('   - RW 006: 4 RT');
        $this->command->info('   - RW 008: 4 RT');
        $this->command->info('   - Total: 22 akun RT');
    }
}