<?php

namespace Database\Seeders;

use App\Models\Division;
use App\Models\User;
use Illuminate\Database\Seeder;

class DivisionSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('is_admin', true)->firstOrFail();

        $divisions = [
            [
                'name' => 'Divisi Pengembangan',
                'slug' => 'divisi-pengembangan',
                'description' => 'Bidang pengembangan program dan kegiatan organisasi.',
            ],
            [
                'name' => 'Divisi Keuangan',
                'slug' => 'divisi-keuangan',
                'description' => 'Bidang manajemen keuangan dan administrasi keuangan.',
            ],
            [
                'name' => 'Divisi Media dan Komunikasi',
                'slug' => 'divisi-media-komunikasi',
                'description' => 'Bidang dokumentasi, media sosial, dan publikasi.',
            ],
            [
                'name' => 'Divisi Pengabdian Masyarakat',
                'slug' => 'divisi-pengabdian-masyarakat',
                'description' => 'Bidang pengabdian dan pemberdayaan masyarakat.',
            ],
        ];

        foreach ($divisions as $data) {
            Division::updateOrCreate(
                ['slug' => $data['slug']],
                array_merge($data, ['user_id' => $admin->id])
            );
        }

        $this->command->info('Data divisi berhasil disiapkan.');
    }
}