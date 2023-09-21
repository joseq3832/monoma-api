<?php

namespace Database\Seeders;

use App\Models\Candidate;
use Illuminate\Database\Seeder;

class CandidateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Candidate::factory()->create([
            'name' => 'Mi candidato',
            'source' => 'Fotocasa',
            'owner' => 2,
            'created_at' => '2020-09-01 16:16:16',
            'created_by' => 1,
        ]);

        Candidate::factory(200)->create();
    }
}
