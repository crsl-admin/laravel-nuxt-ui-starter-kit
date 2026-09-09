<?php

use App\Enum\Permissions;
use App\Enum\Roles;
use App\Models\Customer;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

test('guests are redirected to login', function () {
    $this->get(route('customers'))->assertRedirect(route('login'));
});

test('users without permission cannot view customers', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->get(route('customers'))->assertForbidden();
});

test('users with direct permission can view customers and receive all permissions', function () {
    $user = User::factory()->create();
    $directPermission = Permission::findOrCreate(Permissions::VIEW_ALL_CUSTOMER, 'web');
    $rolePermission = Permission::findOrCreate(Permissions::VIEW_CUSTOMER, 'web');
    $role = Role::findOrCreate('customer-reader', 'web');

    $role->givePermissionTo($rolePermission);
    $user->assignRole($role);
    $user->givePermissionTo($directPermission);

    $this->actingAs($user)
        ->get(route('customers'))
        ->assertInertia(fn (Assert $page) => $page
            ->component('Customers')
            ->where('is_super_admin', false)
            ->where('permissions', [
                Permissions::VIEW_ALL_CUSTOMER->value,
                Permissions::VIEW_CUSTOMER->value,
            ]));
});

test('super admins can view customers without assigned permissions', function () {
    $user = User::factory()->create();
    $role = Role::findOrCreate(Roles::SUPER_ADMIN, 'web');

    $user->assignRole($role);

    expect($role->permissions)->toBeEmpty();

    $this->actingAs($user)
        ->get(route('customers'))
        ->assertInertia(fn (Assert $page) => $page
            ->component('Customers')
            ->where('is_super_admin', true)
            ->where('permissions', []));
});

test('customer policy maps every action to enum permissions', function (
    string $ability,
    Permissions $permission,
    bool $usesCustomer,
) {
    $user = User::factory()->create();
    Permission::findOrCreate($permission, 'web');
    $target = $usesCustomer ? new Customer : Customer::class;

    expect($user->can($ability, $target))->toBeFalse();

    $user->givePermissionTo($permission);

    expect($user->fresh()->can($ability, $target))->toBeTrue();
})->with([
    'list' => ['viewAny', Permissions::VIEW_ALL_CUSTOMER, false],
    'view' => ['view', Permissions::VIEW_CUSTOMER, true],
    'create' => ['create', Permissions::CREATE_CUSTOMER, false],
    'update' => ['update', Permissions::UPDATE_CUSTOMER, true],
    'delete' => ['delete', Permissions::DELETE_CUSTOMER, true],
]);
