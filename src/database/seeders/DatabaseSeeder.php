<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // create Super admin user for testing application
        \App\Models\User::factory()->create([
            'name' => 'Super admin',
            'email' => 'test@hireza.ir',
            'password' => Hash::make('secret')
        ]);
    }
}
