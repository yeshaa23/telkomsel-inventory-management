<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

function roleAccessUser(string $roleName): User
{
    $role = Role::firstOrCreate(['name' => $roleName]);

    return User::factory()->create([
        'role_id' => $role->id,
        'password' => Hash::make('password'),
    ]);
}

test('guest is redirected to login when accessing protected pages', function () {
    $this->get(route('dashboard'))->assertRedirect(route('login'));
    $this->get(route('products.index'))->assertRedirect(route('login'));
    $this->get(route('reports.index'))->assertRedirect(route('login'));
});

test('staff can access operational pages but cannot access reports', function () {
    $staff = roleAccessUser('Staff');

    $this->actingAs($staff)->get(route('dashboard'))->assertOk();
    $this->actingAs($staff)->get(route('categories.index'))->assertOk();
    $this->actingAs($staff)->get(route('products.index'))->assertOk();
    $this->actingAs($staff)->get(route('borrowings.index'))->assertOk();
    $this->actingAs($staff)->get(route('reports.index'))->assertForbidden();
});

test('manager can access dashboard and reports but cannot manage products', function () {
    $manager = roleAccessUser('Manager');

    $this->actingAs($manager)->get(route('dashboard'))->assertOk();
    $this->actingAs($manager)->get(route('reports.index'))->assertOk();
    $this->actingAs($manager)->get(route('products.index'))->assertForbidden();
    $this->actingAs($manager)->get(route('categories.index'))->assertForbidden();
});

test('admin can access all main modules', function () {
    $admin = roleAccessUser('Admin');

    $this->actingAs($admin)->get(route('dashboard'))->assertOk();
    $this->actingAs($admin)->get(route('categories.index'))->assertOk();
    $this->actingAs($admin)->get(route('products.index'))->assertOk();
    $this->actingAs($admin)->get(route('borrowings.index'))->assertOk();
    $this->actingAs($admin)->get(route('reports.index'))->assertOk();
    $this->actingAs($admin)->get(route('activity-logs.index'))->assertOk();
});
