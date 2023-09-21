<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Src\Infraestructure\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Src\Infraestructure\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

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
