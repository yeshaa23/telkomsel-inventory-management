<?php

use App\Models\Category;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

function categoryUser(string $roleName = 'Admin'): User
{
    $role = Role::firstOrCreate(['name' => $roleName]);

    return User::factory()->create([
        'role_id' => $role->id,
        'password' => Hash::make('password'),
    ]);
}

test('admin can view category pages', function () {
    $admin = categoryUser('Admin');

    $category = Category::create([
        'name' => 'Router',
        'description' => 'Perangkat jaringan',
    ]);

    $this->actingAs($admin)->get(route('categories.index'))->assertOk();
    $this->actingAs($admin)->get(route('categories.create'))->assertOk();
    $this->actingAs($admin)->get(route('categories.show', $category))->assertOk();
    $this->actingAs($admin)->get(route('categories.edit', $category))->assertOk();
});

test('admin can update category', function () {
    $admin = categoryUser('Admin');

    $category = Category::create([
        'name' => 'Old Category',
        'description' => 'Old Description',
    ]);

    $this->actingAs($admin)
        ->patch(route('categories.update', $category), [
            'name' => 'Updated Category',
            'description' => 'Updated Description',
        ])
        ->assertRedirect(route('categories.index'));

    $this->assertDatabaseHas('categories', [
        'id' => $category->id,
        'name' => 'Updated Category',
        'description' => 'Updated Description',
    ]);
});

test('admin can delete category', function () {
    $admin = categoryUser('Admin');

    $category = Category::create([
        'name' => 'Temporary Category',
        'description' => 'Will be deleted',
    ]);

    $this->actingAs($admin)
        ->delete(route('categories.destroy', $category))
        ->assertRedirect(route('categories.index'));

    $this->assertDatabaseMissing('categories', [
        'id' => $category->id,
    ]);
});

test('category name must be unique', function () {
    $staff = categoryUser('Staff');

    Category::create([
        'name' => 'Router',
        'description' => 'Kategori pertama',
    ]);

    $this->actingAs($staff)
        ->post(route('categories.store'), [
            'name' => 'Router',
            'description' => 'Kategori duplikat',
        ])
        ->assertSessionHasErrors('name');
});
