<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Candidate>
 */
class CandidateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'source' => fake()->imageUrl(),
            'owner' => User::all()->random()->id,
            'created_at' => now(),
            'created_by' => User::all()->where('role', 'manager')->random()->id,
        ];
    }
}
