<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Story permissions
            'view stories',
            'create stories',
            'edit stories',
            'delete stories',
            'mark sensitive',

            // Comment permissions
            'create comments',
            'edit comments',
            'delete comments',

            // User management
            'view users',
            'edit users',
            'delete users',

            // Dashboard
            'access dashboard',
            'view statistics',

            // Category management
            'manage categories',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo([
            'access dashboard',
            'view statistics',
            'view users',
            'edit users',
            'delete users',
            'view stories',
            'edit stories',
            'delete stories',
            'edit comments',
            'delete comments',
            'manage categories',
        ]);

        $moderatorRole = Role::create(['name' => 'moderator']);
        $moderatorRole->givePermissionTo([
            'mark sensitive',
            'view stories',
            'delete comments',
            'delete stories',
            'access dashboard',
            'view statistics',
        ]);

        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo([
            'view stories',
            'create stories',
            'edit stories',
            'delete stories',
            'create comments',
            'edit comments',
            'delete comments',
            'access dashboard',
            'view statistics',
        ]);

        // Create admin user
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
        ]);
        $admin->assignRole('admin');

        // Create moderator user
        $moderator = User::create([
            'name' => 'Moderator',
            'email' => 'moderator@example.com',
            'password' => Hash::make('password123'),
        ]);
        $moderator->assignRole('moderator');

        // Create normal user
        $user = User::create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => Hash::make('password123'),
        ]);
        $user->assignRole('user');
    }
}
