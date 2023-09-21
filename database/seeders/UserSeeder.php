<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)->create();

        User::factory()->create([
            'username' => 'tester',
            'role' => 'manager',
        ]);

        User::factory()->create([
            'username' => 'agent',
            'role' => 'agent',
        ]);
    }
}
