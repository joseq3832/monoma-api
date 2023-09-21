<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Src\Infraestructure\Models\Candidate;
use Src\Infraestructure\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Candidate>
 */
class CandidateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Candidate::class;

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
