<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'username' => fake()->userName(),
            'password' => bcrypt('PASSWORD'),
            'last_login' => null,
            'is_active' => fake()->boolean(),
            'role' => fake()->randomElement(['manager', 'agent']),
        ];
    }
}
