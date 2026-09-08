<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = collect([
            'customers.view',
            'customers.create',
            'customers.update',
            'customers.delete',
            'users.manage',
        ])->map(
            fn (string $permission): Permission => Permission::findOrCreate($permission, 'web'),
        );

        Role::findOrCreate('admin', 'web')
            ->syncPermissions($permissions);

        Role::findOrCreate('editor', 'web')
            ->syncPermissions($permissions->whereIn('name', [
                'customers.view',
                'customers.create',
                'customers.update',
            ]));

        Role::findOrCreate('viewer', 'web')
            ->syncPermissions($permissions->whereIn('name', [
                'customers.view',
            ]));

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
