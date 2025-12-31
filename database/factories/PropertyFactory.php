<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyFactory extends Factory
{
    public function definition(): array
    {
        return [
            'landlord_id' => User::factory()->state(['role' => 'landlord']),
            'name' => $this->faker->streetName(),
            'address' => $this->faker->address(),
            'description' => $this->faker->sentence(10),
        ];
    }
}
