<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ManagementPeriod>
 */
class ManagementPeriodFactory extends Factory
{
    protected $model = \App\Models\ManagementPeriod::class;

    public function definition(): array
    {
        $start = fake()->dateTimeBetween('-2 years', '-1 year');
        $end = fake()->dateTimeBetween('-1 year', '+1 year');

        return [
            'name' => 'Periode '.fake()->year(),
            'start_date' => $start,
            'end_date' => $end,
            'is_active' => false,
            'description' => fake()->sentence(),
            'user_id' => null,
        ];
    }
}