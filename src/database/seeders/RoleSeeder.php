<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role_names = ['staff', 'store manager', 'system admin'];
        foreach ($role_names as $role_name) {
            Role::factory()->create([
                'name' => $role_name,
                'guard_name' => 'web'
            ]);
        }
    }
}
