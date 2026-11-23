<?php

namespace Database\Seeders;

use App\Models\ManagementPeriod;
use App\Models\User;
use Illuminate\Database\Seeder;

class ManagementPeriodSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('is_admin', true)->firstOrFail();

        $periods = [
            [
                'name' => 'Periode 2024-2026',
                'start_date' => '2024-01-01',
                'end_date' => '2026-12-31',
                'is_active' => true,
                'description' => 'Periode kepengurusan aktif saat ini.',
                'user_id' => $admin->id,
            ],
            [
                'name' => 'Periode 2022-2024',
                'start_date' => '2022-01-01',
                'end_date' => '2024-12-31',
                'is_active' => false,
                'description' => 'Periode kepengurusan sebelumnya (data arsip).',
                'user_id' => $admin->id,
            ],
        ];

        foreach ($periods as $data) {
            ManagementPeriod::updateOrCreate(
                ['name' => $data['name']],
                $data
            );
        }

        $this->command->info('Data periode kepengurusan berhasil disiapkan.');
    }
}