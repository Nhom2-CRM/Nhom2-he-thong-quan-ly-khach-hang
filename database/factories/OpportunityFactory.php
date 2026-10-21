<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OpportunityFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'team_id' => 1,
            'name' => 'Hợp đồng ' . $this->faker->company(),
            'amount' => $this->faker->numberBetween(50000000, 500000000), // 50tr - 500tr
            'probability' => $this->faker->randomElement([10, 30, 50, 70, 90]), // Xác suất %
            'expected_close_date' => $this->faker->dateTimeBetween('-1 month', '+2 months')->format('Y-m-d'),
            'status' => $this->faker->randomElement(['in_progress', 'won', 'lost']),
        ];
    }
}