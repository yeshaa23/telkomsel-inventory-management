<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('name', 'Admin')->first();
        $staffRole = Role::where('name', 'Staff')->first();
        $managerRole = Role::where('name', 'Manager')->first();

        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role_id' => $adminRole->id,
            ]
        );

        User::firstOrCreate(
            ['email' => 'staff@example.com'],
            [
                'name' => 'Staff',
                'password' => Hash::make('password'),
                'role_id' => $staffRole->id,
            ]
        );

        User::firstOrCreate(
            ['email' => 'manager@example.com'],
            [
                'name' => 'Manager',
                'password' => Hash::make('password'),
                'role_id' => $managerRole->id,
            ]
        );
    }
}
