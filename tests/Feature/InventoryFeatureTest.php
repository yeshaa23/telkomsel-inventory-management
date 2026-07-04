<?php

use App\Models\Borrowing;
use App\Models\Category;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

function inventoryUserWithRole(string $roleName): User
{
    $role = Role::firstOrCreate([
        'name' => $roleName,
    ]);

    return User::factory()->create([
        'role_id' => $role->id,
        'password' => Hash::make('password'),
    ]);
}

function inventoryProduct(int $stock = 10, string $condition = 'Baik'): Product
{
    $category = Category::create([
        'name' => 'Router',
        'description' => 'Perangkat jaringan',
    ]);

    return Product::create([
        'category_id' => $category->id,
        'code' => 'RTR-0001',
        'name' => 'Router Telkomsel',
        'stock' => $stock,
        'location' => 'Gudang A',
        'condition' => $condition,
    ]);
}

test('guest is redirected to login when accessing dashboard', function () {
    $this->get('/dashboard')
        ->assertRedirect('/login');
});

test('admin can access dashboard', function () {
    $admin = inventoryUserWithRole('Admin');

    $this->actingAs($admin)
        ->get('/dashboard')
        ->assertOk();
});

test('staff can create category', function () {
    $staff = inventoryUserWithRole('Staff');

    $this->actingAs($staff)
        ->post(route('categories.store'), [
            'name' => 'Modem',
            'description' => 'Perangkat modem',
        ])
        ->assertRedirect(route('categories.index'));

    $this->assertDatabaseHas('categories', [
        'name' => 'Modem',
        'description' => 'Perangkat modem',
    ]);
});

test('manager cannot access category management', function () {
    $manager = inventoryUserWithRole('Manager');

    $this->actingAs($manager)
        ->get(route('categories.index'))
        ->assertForbidden();
});

test('staff can create product with generated code', function () {
    $staff = inventoryUserWithRole('Staff');

    $category = Category::create([
        'name' => 'Switch',
        'description' => 'Perangkat switch jaringan',
    ]);

    $this->actingAs($staff)
        ->post(route('products.store'), [
            'category_id' => $category->id,
            'name' => 'Switch Cisco',
            'stock' => 8,
            'location_select' => 'Gudang B',
            'condition' => 'Baik',
        ])
        ->assertRedirect(route('products.index'));

    $product = Product::where('name', 'Switch Cisco')->first();

    expect($product)->not->toBeNull();
    expect($product->code)->toStartWith('SWI-');

    $this->assertDatabaseHas('products', [
        'name' => 'Switch Cisco',
        'stock' => 8,
        'location' => 'Gudang B',
        'condition' => 'Baik',
    ]);
});

test('staff can create borrowing with division and product stock is reduced', function () {
    $staff = inventoryUserWithRole('Staff');
    $product = inventoryProduct(stock: 10);

    $this->actingAs($staff)
        ->post(route('borrowings.store'), [
            'borrower_name' => 'Ayesha Hana',
            'division' => 'IT Support',
            'borrow_date' => now()->toDateString(),
            'due_date' => now()->addDays(7)->toDateString(),
            'product_id' => $product->id,
            'quantity' => 3,
        ])
        ->assertRedirect(route('borrowings.index'));

    $this->assertDatabaseHas('borrowings', [
        'borrower_name' => 'Ayesha Hana',
        'division' => 'IT Support',
        'status' => 'borrowed',
    ]);

    expect($product->fresh()->stock)->toBe(7);
});

test('staff can return borrowed product and stock is restored', function () {
    $staff = inventoryUserWithRole('Staff');
    $product = inventoryProduct(stock: 10);

    $this->actingAs($staff)
        ->post(route('borrowings.store'), [
            'borrower_name' => 'Ayesha Hana',
            'division' => 'Network Operation',
            'borrow_date' => now()->toDateString(),
            'due_date' => now()->addDays(7)->toDateString(),
            'product_id' => $product->id,
            'quantity' => 2,
        ])
        ->assertRedirect(route('borrowings.index'));

    $borrowing = Borrowing::first();

    expect($product->fresh()->stock)->toBe(8);

    $this->actingAs($staff)
        ->patch(route('borrowings.return', $borrowing), [
            'return_condition' => 'Baik',
            'return_note' => 'Barang dikembalikan dalam kondisi baik.',
        ])
        ->assertRedirect(route('borrowings.index'));

    expect($product->fresh()->stock)->toBe(10);

    $this->assertDatabaseHas('borrowings', [
        'id' => $borrowing->id,
        'status' => 'returned',
        'return_condition' => 'Baik',
        'return_note' => 'Barang dikembalikan dalam kondisi baik.',
    ]);
});

test('admin can access activity logs', function () {
    $admin = inventoryUserWithRole('Admin');

    $this->actingAs($admin)
        ->get(route('activity-logs.index'))
        ->assertOk();
});
