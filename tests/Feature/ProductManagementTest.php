<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

function productUser(string $roleName = 'Admin'): User
{
    $role = Role::firstOrCreate(['name' => $roleName]);

    return User::factory()->create([
        'role_id' => $role->id,
        'password' => Hash::make('password'),
    ]);
}

function productCategory(): Category
{
    return Category::create([
        'name' => 'Router',
        'description' => 'Perangkat jaringan',
    ]);
}

function sampleProduct(array $overrides = []): Product
{
    $category = $overrides['category'] ?? productCategory();

    unset($overrides['category']);

    return Product::create(array_merge([
        'category_id' => $category->id,
        'code' => 'RTR-0001',
        'name' => 'Router Telkomsel',
        'stock' => 10,
        'location' => 'Gudang A',
        'condition' => 'Baik',
    ], $overrides));
}

test('admin can view product pages', function () {
    $admin = productUser('Admin');
    $product = sampleProduct();

    $this->actingAs($admin)->get(route('products.index'))->assertOk();
    $this->actingAs($admin)->get(route('products.create'))->assertOk();
    $this->actingAs($admin)->get(route('products.show', $product))->assertOk();
    $this->actingAs($admin)->get(route('products.edit', $product))->assertOk();
});

test('product index supports search and filters', function () {
    $admin = productUser('Admin');

    $category = Category::create([
        'name' => 'Switch',
        'description' => 'Perangkat switch',
    ]);

    sampleProduct([
        'category' => $category,
        'code' => 'SWI-0001',
        'name' => 'Switch Cisco',
        'stock' => 3,
        'location' => 'Gudang B',
        'condition' => 'Baik',
    ]);

    $this->actingAs($admin)
        ->get(route('products.index', [
            'search' => 'Switch',
            'category_id' => $category->id,
            'condition' => 'Baik',
            'location' => 'Gudang B',
            'stock_status' => 'low_stock',
            'sort' => 'stock_asc',
        ]))
        ->assertOk()
        ->assertSee('Switch Cisco');
});

test('admin can update product using custom location', function () {
    $admin = productUser('Admin');

    $category = Category::create([
        'name' => 'Modem',
        'description' => 'Perangkat modem',
    ]);

    $product = sampleProduct([
        'category' => $category,
        'code' => 'MOD-0001',
        'name' => 'Modem Lama',
        'stock' => 5,
        'location' => 'Gudang A',
        'condition' => 'Baik',
    ]);

    $this->actingAs($admin)
        ->patch(route('products.update', $product), [
            'category_id' => $category->id,
            'code' => 'MOD-0002',
            'name' => 'Modem Baru',
            'stock' => 12,
            'location_select' => 'other',
            'location_other' => 'Gudang Baru',
            'condition' => 'Rusak Ringan',
        ])
        ->assertRedirect(route('products.index'));

    $this->assertDatabaseHas('products', [
        'id' => $product->id,
        'code' => 'MOD-0002',
        'name' => 'Modem Baru',
        'stock' => 12,
        'location' => 'Gudang Baru',
        'condition' => 'Rusak Ringan',
    ]);
});

test('admin can delete product', function () {
    $admin = productUser('Admin');
    $product = sampleProduct();

    $this->actingAs($admin)
        ->delete(route('products.destroy', $product))
        ->assertRedirect(route('products.index'));

    $this->assertDatabaseMissing('products', [
        'id' => $product->id,
    ]);
});

test('product generate code returns json code', function () {
    $admin = productUser('Admin');

    $category = Category::create([
        'name' => 'Access Point',
        'description' => 'Perangkat AP',
    ]);

    $this->actingAs($admin)
        ->get(route('products.generate-code', [
            'category_id' => $category->id,
        ]))
        ->assertOk()
        ->assertJsonStructure(['code']);
});
