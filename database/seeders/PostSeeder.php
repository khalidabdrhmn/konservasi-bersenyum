<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('is_admin', true)->firstOrFail();

        $posts = [
            [
                'title' => 'Selamat Datang di Konservasi Bersenyum',
                'slug' => 'selamat-datang-di-konservasi-bersenyum',
                'excerpt' => 'Mari bersama menjaga lingkungan untuk masa depan yang lebih baik.',
                'content' => '<p>Konservasi Bersenyum hadir sebagai wadah kepedulian lingkungan, pelestarian alam, dan pemberdayaan masyarakat. Bergabunglah dengan kami dalam berbagai kegiatan konservasi yang bermanfaat.</p>',
                'status' => 'published',
                'published_at' => now(),
            ],
            [
                'title' => 'Kegiatan Penanaman Pohon di Kawasan Hutan',
                'slug' => 'kegiatan-penanaman-pohon-di-kawasan-hutan',
                'excerpt' => 'Aksi penanaman pohon sebagai bentuk keberlanjutan lingkungan.',
                'content' => '<p>Kegiatan penanaman pohon di kawasan hutan dilakukan untuk melestarikan ekosistem dan mengurangi dampak perubahan iklim.</p>',
                'status' => 'published',
                'published_at' => now(),
            ],
            [
                'title' => 'Edukasi Lingkungan untuk Anak-Anak',
                'slug' => 'edukasi-lingkungan-untuk-anak-anak',
                'excerpt' => 'Menganakarkan kepedulian lingkungan sejak dini kepada generasi muda.',
                'content' => '<p>Program edukasi lingkungan dirancang untuk mengajarkan anak-anak tentang pentingnya melestarikan alam sekitar.</p>',
                'status' => 'draft',
                'published_at' => null,
            ],
        ];

        foreach ($posts as $data) {
            Post::updateOrCreate(
                ['slug' => $data['slug']],
                array_merge($data, ['user_id' => $admin->id])
            );
        }

        $this->command->info('Data berita dan artikel berhasil disiapkan.');
    }
}