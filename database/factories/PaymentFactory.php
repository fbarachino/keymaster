<?php

namespace Database\Factories;

use App\Models\Lease;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    public function definition(): array
    {
        $due = $this->faker->dateTimeBetween('-6 months', '+6 months');

        return [
            'lease_id' => Lease::factory(),
            'due_date' => $due,
            'paid_date' => $this->faker->boolean(70) ? $this->faker->dateTimeBetween($due, 'now') : null,
            'amount' => $this->faker->randomFloat(2, 300, 1500),
            'status' => $this->faker->randomElement(['pending', 'paid', 'overdue']),
        ];
    }
}
