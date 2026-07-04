<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
uses(Tests\TestCase::class, RefreshDatabase::class);

use App\Models\ActivityLog;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('activity log can record authenticated user activity', function () {
    $role = Role::firstOrCreate(['name' => 'Admin']);

    $user = User::factory()->create([
        'role_id' => $role->id,
        'password' => Hash::make('password'),
    ]);

    $this->actingAs($user);

    ActivityLog::record('create', 'products', 'Menambahkan barang baru', [
        'product' => 'Router',
    ]);

    $this->assertDatabaseHas('activity_logs', [
        'user_id' => $user->id,
        'action' => 'create',
        'module' => 'products',
        'description' => 'Menambahkan barang baru',
    ]);

    expect(ActivityLog::first()->data)->toBe([
        'product' => 'Router',
    ]);
});
