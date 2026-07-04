<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

function productValidationUser(): User
{
    $role = Role::firstOrCreate(['name' => 'Staff']);

    return User::factory()->create([
        'role_id' => $role->id,
        'password' => Hash::make('password'),
    ]);
}

test('product stock cannot be negative', function () {
    $staff = productValidationUser();

    $category = Category::create([
        'name' => 'Router',
        'description' => 'Perangkat jaringan',
    ]);

    $this->actingAs($staff)
        ->post(route('products.store'), [
            'category_id' => $category->id,
            'name' => 'Router Test',
            'stock' => -1,
            'location_select' => 'Gudang A',
            'condition' => 'Baik',
        ])
        ->assertSessionHasErrors('stock');
});

test('product code must be unique', function () {
    $staff = productValidationUser();

    $category = Category::create([
        'name' => 'Modem',
        'description' => 'Perangkat modem',
    ]);

    Product::create([
        'category_id' => $category->id,
        'code' => 'MOD-0001',
        'name' => 'Modem Lama',
        'stock' => 5,
        'location' => 'Gudang A',
        'condition' => 'Baik',
    ]);

    $this->actingAs($staff)
        ->post(route('products.store'), [
            'category_id' => $category->id,
            'code' => 'MOD-0001',
            'name' => 'Modem Baru',
            'stock' => 5,
            'location_select' => 'Gudang B',
            'condition' => 'Baik',
        ])
        ->assertSessionHasErrors('code');
});

test('duplicate product with same name category and location is rejected', function () {
    $staff = productValidationUser();

    $category = Category::create([
        'name' => 'Switch',
        'description' => 'Perangkat switch',
    ]);

    Product::create([
        'category_id' => $category->id,
        'code' => 'SWI-0001',
        'name' => 'Switch Cisco',
        'stock' => 5,
        'location' => 'Gudang A',
        'condition' => 'Baik',
    ]);

    $this->actingAs($staff)
        ->post(route('products.store'), [
            'category_id' => $category->id,
            'name' => 'Switch Cisco',
            'stock' => 5,
            'location_select' => 'Gudang A',
            'condition' => 'Baik',
        ])
        ->assertSessionHasErrors('name');
});
