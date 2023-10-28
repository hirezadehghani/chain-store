<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // then create roles
        $role_names = ['staff', 'store manager', 'system admin'];
        foreach ($role_names as $role_name) {
            Role::create([
                'name' => $role_name,
                'guard_name' => 'backpack'
            ]);
        }
    }
}
