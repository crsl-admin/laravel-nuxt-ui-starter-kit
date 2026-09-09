<?php

namespace Database\Seeders;

use App\Enum\Permissions;
use App\Enum\Roles;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        foreach (Permissions::cases() as $permission) {
            Permission::findOrCreate($permission, 'web');
        }

        $superAdminRole = Role::findOrCreate(Roles::SUPER_ADMIN, 'web');
        $superAdminRole->syncPermissions([]);

        $this->migrateLegacyDirectPermissions();
        $this->migrateLegacyRoles($superAdminRole);
        $this->removeUnusedLegacyPermissions();

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    private function migrateLegacyRoles(Role $superAdminRole): void
    {
        Role::query()
            ->where('name', 'admin')
            ->where('guard_name', 'web')
            ->first()
            ?->users
            ->each(fn (User $user) => $user->assignRole($superAdminRole));

        Role::query()
            ->where('name', 'admin')
            ->where('guard_name', 'web')
            ->get()
            ->each
            ->delete();
    }

    private function migrateLegacyDirectPermissions(): void
    {
        $legacyPermissions = [
            'customers.view' => [Permissions::VIEW_ALL_CUSTOMER, Permissions::VIEW_CUSTOMER],
            'customers.create' => [Permissions::CREATE_CUSTOMER],
            'customers.update' => [Permissions::UPDATE_CUSTOMER],
            'customers.delete' => [Permissions::DELETE_CUSTOMER],
        ];

        foreach ($legacyPermissions as $legacyPermission => $permissions) {
            $permission = Permission::query()
                ->where('name', $legacyPermission)
                ->where('guard_name', 'web')
                ->first();

            if (! $permission) {
                continue;
            }

            $permission->users->each(function (User $user) use ($permission, $permissions): void {
                $user->givePermissionTo($permissions);
                $user->revokePermissionTo($permission);
            });
        }
    }

    private function removeUnusedLegacyPermissions(): void
    {
        Permission::query()
            ->whereIn('name', [
                'customers.view',
                'customers.create',
                'customers.update',
                'customers.delete',
                'users.manage',
            ])
            ->whereDoesntHave('roles')
            ->whereDoesntHave('users')
            ->get()
            ->each
            ->delete();
    }
}
