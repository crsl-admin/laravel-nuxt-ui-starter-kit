<?php

use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;
use Spatie\Permission\Models\Permission;

test('guests are redirected to login', function () {
    $this->get(route('customers'))
        ->assertRedirect(route('login'));
});

test('users without permission cannot view customers', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('customers'))
        ->assertForbidden();
});

test('users without permission do not receive the customers navigation authorization', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/dashboard')
        ->assertInertia(fn (Assert $page) => $page
            ->where('auth.can.viewCustomers', false));
});

test('users with permission can view customers', function () {
    $user = User::factory()->create();
    $permission = Permission::findOrCreate('customers.view', 'web');

    $user->givePermissionTo($permission);

    $this->actingAs($user)
        ->get(route('customers'))
        ->assertInertia(fn (Assert $page) => $page
            ->component('Customers')
            ->where('auth.can.viewCustomers', true));
});
