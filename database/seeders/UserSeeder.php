<?php

namespace Database\Seeders;

use Database\Factories\UserFactory;
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
        $factory = new UserFactory();

        $factory->count(10)->create();

        $factory->create([
            'username' => 'tester',
            'role' => 'manager',
        ]);

        $factory->create([
            'username' => 'agent',
            'role' => 'agent',
        ]);
    }
}
