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
        $rtUsers = [
            ['name' => 'RT 01', 'email' => 'rt01@example.com', 'password' => 'password', 'role' => 'rt'],
            ['name' => 'RT 02', 'email' => 'rt02@example.com', 'password' => 'password', 'role' => 'rt'],
            ['name' => 'RT 03', 'email' => 'rt03@example.com', 'password' => 'password', 'role' => 'rt'],
            ['name' => 'RT 04', 'email' => 'rt04@example.com', 'password' => 'password', 'role' => 'rt'],
            ['name' => 'RT 05', 'email' => 'rt05@example.com', 'password' => 'password', 'role' => 'rt'],
        ];

        foreach ($rtUsers as $data) {
            $user = User::where('email', $data['email'])->first();
            
            if (!$user) {
                $user = User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                    'role' => $data['role'],
                ]);
            }

            $rt = Rt::where('user_id', $user->id)->first();
            if (!$rt) {
                $rt = Rt::create([
                    'user_id' => $user->id,
                    'rt_number' => substr($data['name'], -2),
                    'rw_number' => '03',
                    'alamat' => 'Jl. Contoh No. 123, Kelurahan Galung Maloang',
                    'phone_number' => '08123456789',
                    'is_active' => true,
                ]);
            }
            
            // **INI YANG DITAMBAHKAN**: Update rt_id di user
            if ($user->rt_id !== $rt->id) {
                $user->rt_id = $rt->id;
                $user->save();
            }
        }

        $this->command->info('✅ RT Seeder berhasil dijalankan!');
        $this->command->info('📧 Akun RT: rt01@example.com - rt05@example.com');
        $this->command->info('🔑 Password: password');
    }
}