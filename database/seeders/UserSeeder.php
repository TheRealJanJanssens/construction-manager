<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->hasMeta()->create();

        \App\Models\User::factory()->hasMeta()->password('password')->create([
            'first_name' => 'Jan',
            'last_name' => 'Janssens',
            'email' => 'hello@janjanssens.be',
        ]);
    }
}
