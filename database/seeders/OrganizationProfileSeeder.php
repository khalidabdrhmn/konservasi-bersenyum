<?php

namespace Database\Seeders;

use App\Models\OrganizationProfile;
use Illuminate\Database\Seeder;

class OrganizationProfileSeeder extends Seeder
{
    public function run(): void
    {
        OrganizationProfile::updateOrCreate(
            ['id' => 1],
            [
                'name' => 'Konservasi Bersenyum',

                'tagline' => 'se-UNNES se-TEMANGGUNGAN',

                'logo_path' => null,

                'hero_title' =>
                    'Ikatan Mahasiswa Temanggung UNNES Temanggung',

                'hero_description' =>
                    'Kami percaya bahwa setiap individu memiliki kesempatan untuk berkembang. Melalui pendidikan, pemberdayaan, dan kepedulian, kami berupaya menciptakan dampak positif yang berkelanjutan.',

                'hero_image' => null,

                'about_title' =>
                    'Setiap Langkah Kecil Membawa Perubahan Besar',

                'about_description' =>
                    'Konservasi Bersenyum hadir dengan semangat untuk memberikan kontribusi nyata bagi masyarakat. Kami berkomitmen mendukung potensi individu melalui berbagai inisiatif yang berorientasi pada pendidikan, pengembangan kapasitas, dan kesejahteraan sosial. Kami percaya bahwa masa depan yang lebih baik dapat diwujudkan melalui kolaborasi, kepedulian, dan kesempatan yang terbuka bagi semua orang.',

                'about_image' => null,

                // Diisi setelah informasi resmi tersedia
                'email' => null,
                'phone' => null,
                'address' => null,

                'instagram' => null,
                'facebook' => null,
                'youtube' => null,

                'footer_text' =>
                    'Dari Temanggung ke UNNES kembali untuk Temanggung.',
            ]
        );

        $this->command->info(
            'Profil Konservasi Bersenyum berhasil disiapkan.'
        );
    }
}
