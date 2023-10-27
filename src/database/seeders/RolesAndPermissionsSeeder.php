<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // first of all create permissions
        $permissions = ['articles', 'employees', 'branches', 'roles'];
        $accesses = ['read', 'write', 'delete', 'edit'];
        foreach ($permissions as $permission) {
            foreach ($accesses as $access) {
                Permission::create([
                    'name' => $access . ' ' . $permission,
                    'guard_name' => 'web'
                ]);
            }
        }

        // then create roles
        $role_names = ['staff', 'store manager', 'system admin'];
        foreach ($role_names as $role_name) {
            Role::create([
                'name' => $role_name,
                'guard_name' => 'web'
            ]);
        }

        // finally assign permission to roles

        // assign system admin permissions
        $system_admin = Role::where('name', 'system admin')->first();
        $system_admin->givePermissionTo(Permission::all());

        // assign store manager permissions
        $store_manager = Role::where('name', 'store manager')->first();
        $store_manager->givePermissionTo(['read employees', 'write employees', 'read branches', 'write branches', 'read articles', 'write articles']);

        $staff = Role::where('name', 'staff')->first();
        $staff->givePermissionTo(['read employees', 'read articles', 'read branches']);
    }
}
