<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create Super admin user for testing application
        Employee::factory()->create([
            'name' => 'Super admin',
            'email' => 'test@hireza.ir',
            'username' => 'hireza',
            'job_title' => 'Junior back-end developer',
            'password' => Hash::make('secret')
        ]);
        // create 10 employee from dummy data
        Employee::factory(10)->create();
    }
}
