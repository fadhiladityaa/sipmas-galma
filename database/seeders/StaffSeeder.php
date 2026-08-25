<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StaffSeeder extends Seeder
{
    public function run(): void
    {
        $staff = User::where('email', 'staff@example.com')->first();
        if (!$staff) {
            User::create([
                'name' => 'Staff Kelurahan',
                'email' => 'staff@example.com',
                'password' => Hash::make('password'),
                'role' => 'staff',
            ]);
        }

        $this->command->info('✅ Staff Seeder berhasil!');
        $this->command->info('📧 Email: staff@example.com');
        $this->command->info('🔑 Password: password');
    }
}