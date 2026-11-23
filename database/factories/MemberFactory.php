<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
{
    protected $model = \App\Models\Member::class;

    public function definition(): array
    {
        $name = fake()->name();

        return [
            'management_period_id' => null,
            'division_id' => null,
            'name' => $name,
            'position' => fake()->randomElement([
                'Ketua Umum',
                'Wakil Ketua',
                'Sekretaris',
                'Bendahara',
                'Anggota',
            ]),
            'slug' => Str::slug($name),
            'bio' => fake()->paragraph(),
            'photo' => null,
            'instagram' => null,
            'linkedin' => null,
            'start_date' => null,
            'end_date' => null,
            'user_id' => null,
        ];
    }
}