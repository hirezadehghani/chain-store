<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permission for each combination of table.level
        collect([ // tables
            'employees',
            'branches',
            'branches',
            'articles',
            'categories',
            'roles',
            'permissions',
        ])
            ->crossJoin([ // levels
                'see',
                'edit',
            ])
            ->each(
                fn (array $item) => Permission::firstOrCreate([
                    'name' => implode('.', $item),
                ])
                    ->save()
            );

        // assign roles to permissions
        $system_admin = Role::where('name', 'system admin')->first();
        $system_admin->givePermissionTo(Permission::all());

        $store_managers = Role::where('name', 'store manager')->get();
        foreach ($store_managers as $store_manager) {
            $store_manager->givePermissionTo(['employees.see', 'employees.edit', 'branches.see', 'branches.edit', 'articles.see', 'articles.edit', 'categories.see', 'categories.edit']);
        }

        $staffs = Role::where('name', 'staff')->get();
        foreach ($staffs as $staff) {
            $staff->givePermissionTo(['employees.see', 'branches.see', 'articles.see']);
        }
    }
}
