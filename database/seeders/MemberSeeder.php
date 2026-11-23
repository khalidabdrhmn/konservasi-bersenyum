<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\ManagementPeriod;
use App\Models\Division;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MemberSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('is_admin', true)->firstOrFail();
        $period = ManagementPeriod::where('is_active', true)->firstOrFail();
        $divisions = Division::all();

        $members = [
            [
                'name' => 'Budi Santoso',
                'position' => 'Ketua Umum',
                'division' => $divisions->first(),
                'bio' => 'Memimpin organisasi dalam mewujudkan visi konservasi dan pelestarian lingkungan.',
            ],
            [
                'name' => 'Siti Rahayu',
                'position' => 'Sekretaris',
                'division' => $divisions->skip(1)->first(),
                'bio' => 'Mengelola administrasi, korespondensi, dan dokumentasi kegiatan organisasi.',
            ],
            [
                'name' => 'Ahmad Fauzi',
                'position' => 'Bendahara',
                'division' => $divisions->skip(1)->first(),
                'bio' => 'Bertanggung jawab atas manajemen keuangan dan pelaporan keuangan organisasi.',
            ],
            [
                'name' => 'Dewi Lestari',
                'position' => 'Anggota',
                'division' => $divisions->skip(2)->first(),
                'bio' => 'Aktif dalam kegiatan pengabdian kepada masyarakat dan konservasi lingkungan.',
            ],
        ];

        foreach ($members as $data) {
            Member::updateOrCreate(
                ['slug' => Str::slug($data['name'])],
                array_merge($data, [
                    'management_period_id' => $period->id,
                    'division_id' => $data['division']?->id,
                    'user_id' => $admin->id,
                ])
            );
        }

        $this->command->info('Data anggota kepengurusan berhasil disiapkan.');
    }
}