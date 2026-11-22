<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = config('admin.email');
        $password = config('admin.password');

        if (empty($email) || empty($password)) {
            throw new RuntimeException(
                'ADMIN_EMAIL dan ADMIN_PASSWORD harus diisi di file .env'
            );
        }

        // Membuat administrator jika belum tersedia
        $admin = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => config('admin.name', 'Administrator'),
                'password' => Hash::make($password),
                'is_admin' => true,
            ]
        );

        // Memastikan akun tersebut memiliki hak administrator
        $admin->forceFill([
            'name' => config('admin.name', 'Administrator'),
            'is_admin' => true,
        ])->save();

        $this->command->info(
            'Akun administrator berhasil disiapkan.'
        );
    }
}
