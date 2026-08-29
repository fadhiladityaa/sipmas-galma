<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StaffSeeder extends Seeder
{
    public function run(): void
    {
        $staffData = [
            ['name' => 'Staff 1', 'email' => 'staff1@sipmas-galma.com'],
            ['name' => 'Staff 2', 'email' => 'staff2@sipmas-galma.com'],
            ['name' => 'Staff 3', 'email' => 'staff3@sipmas-galma.com'],
            ['name' => 'Staff 4', 'email' => 'staff4@sipmas-galma.com'],
        ];

        foreach ($staffData as $data) {
            User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => Hash::make('password'),
                    'role' => 'staff',
                ]
            );
        }

        $this->command->info('✅ 4 akun staff berhasil dibuat!');
        $this->command->info('📧 Email: staff1@sipmas-galma.com - staff4@sipmas-galma.com');
        $this->command->info('🔑 Password: password');
    }
}