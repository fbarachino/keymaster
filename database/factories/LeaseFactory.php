<?php

namespace Database\Factories;

use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeaseFactory extends Factory
{
    public function definition(): array
    {
        $start = $this->faker->dateTimeBetween('-1 year', 'now');
        $end = (clone $start)->modify('+1 year');

        return [
            'unit_id' => Unit::factory(),
            'tenant_id' => User::factory()->state(['role' => 'tenant']),
            'start_date' => $start,
            'end_date' => $end,
            'rent_amount' => $this->faker->randomFloat(2, 300, 1500),
            'deposit_amount' => $this->faker->randomFloat(2, 300, 1500),
            'status' => 'active',
        ];
    }
}
