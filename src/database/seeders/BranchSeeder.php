<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Branch::factory()->create([
            'name' => 'Central',
            'address' => 'Tehran'
        ]);

        // create 10 employee from dummy data
        Branch::factory(10)->create();
    }

}
