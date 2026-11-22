<?php

namespace Database\Seeders;

use App\Models\Program;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('is_admin', true)->firstOrFail();

        $programs = [
            [
                'title' => 'Program Pendidikan',
                'slug' => 'program-pendidikan',
                'category' => 'Pendidikan',
                'excerpt' =>
                    'Meningkatkan akses dan kualitas pendidikan bagi generasi muda Indonesia.',
                'description' =>
                    'Program pendidikan merupakan inisiatif Konservasi Bersenyum untuk mendukung pengembangan potensi generasi muda melalui kegiatan edukasi, pendampingan, dan peningkatan kapasitas.',
                'image' => null,
                'status' => 'published',
                'published_at' => '2026-08-25 08:00:00',
                'sort_order' => 1,
            ],
            [
                'title' => 'Pemberdayaan Masyarakat',
                'slug' => 'pemberdayaan-masyarakat',
                'category' => 'Pemberdayaan',
                'excerpt' =>
                    'Mendorong masyarakat untuk berkembang secara mandiri dan berkelanjutan.',
                'description' =>
                    'Program pemberdayaan masyarakat berfokus pada pengembangan kemampuan, kolaborasi, dan peningkatan kesejahteraan masyarakat melalui kegiatan yang memberikan manfaat berkelanjutan.',
                'image' => null,
                'status' => 'published',
                'published_at' => '2026-08-25 09:00:00',
                'sort_order' => 2,
            ],
            [
                'title' => 'Pelestarian Lingkungan',
                'slug' => 'pelestarian-lingkungan',
                'category' => 'Lingkungan',
                'excerpt' =>
                    'Meningkatkan kepedulian dan partisipasi masyarakat terhadap kelestarian lingkungan.',
                'description' =>
                    'Program pelestarian lingkungan mengajak masyarakat untuk berpartisipasi dalam menjaga lingkungan melalui edukasi, aksi kepedulian, dan kegiatan konservasi.',
                'image' => null,
                'status' => 'published',
                'published_at' => '2026-08-25 10:00:00',
                'sort_order' => 3,
            ],
        ];

        foreach ($programs as $data) {
            Program::updateOrCreate(
                ['slug' => $data['slug']],
                array_merge($data, [
                    'user_id' => $admin->id,
                ])
            );
        }

        $this->command->info(
            'Data program organisasi berhasil disiapkan.'
        );
    }
}
