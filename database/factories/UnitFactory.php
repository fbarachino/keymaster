<?php

namespace Database\Factories;

use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;

class UnitFactory extends Factory
{
    public function definition(): array
    {
        return [
            'property_id' => Property::factory(),
            'name' => 'Unit ' . $this->faker->unique()->numberBetween(1, 50),
            'floor' => $this->faker->numberBetween(0, 5),
            'size' => $this->faker->numberBetween(20, 150),
            'monthly_rent' => $this->faker->randomFloat(2, 300, 1500),
            'status' => $this->faker->randomElement(['available', 'occupied']),
        ];
    }
}
