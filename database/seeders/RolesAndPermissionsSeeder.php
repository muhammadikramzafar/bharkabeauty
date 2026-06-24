<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ─── PERMISSIONS ──────────────────────────────────────────
        $permissions = [
            // Products
            'view products', 'create products', 'edit products', 'delete products',
            // Categories
            'view categories', 'create categories', 'edit categories', 'delete categories',
            // Brands
            'view brands', 'create brands', 'edit brands', 'delete brands',
            // Orders
            'view orders', 'edit orders', 'delete orders',
            // Customers
            'view customers', 'edit customers',
            // Users & Roles
            'view users', 'create users', 'edit users', 'delete users', 'assign roles',
            // Settings
            'manage settings',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // ─── ROLES ────────────────────────────────────────────────
        $superAdmin = Role::firstOrCreate(['name' => 'super-admin']);
        $admin      = Role::firstOrCreate(['name' => 'admin']);
        $editor     = Role::firstOrCreate(['name' => 'editor']);

        // Super Admin gets all permissions
        $superAdmin->syncPermissions(Permission::all());

        // Admin gets all except user management
        $admin->syncPermissions([
            'view products', 'create products', 'edit products', 'delete products',
            'view categories', 'create categories', 'edit categories', 'delete categories',
            'view brands', 'create brands', 'edit brands', 'delete brands',
            'view orders', 'edit orders', 'delete orders',
            'view customers', 'edit customers',
        ]);

        // Editor can only view and edit content
        $editor->syncPermissions([
            'view products', 'edit products',
            'view categories', 'edit categories',
            'view brands', 'edit brands',
            'view orders',
        ]);

        // ─── CREATE SUPER ADMIN USER ──────────────────────────────
        $superAdminUser = User::firstOrCreate(
            ['email' => 'superadmin@bharkabeauty.com'],
            [
                'name'     => 'Super Admin',
                'password' => Hash::make('Admin@1234'),
            ]
        );
        $superAdminUser->assignRole('super-admin');

        $this->command->info('Roles and permissions seeded successfully.');
        $this->command->info('Super Admin: superadmin@bharkabeauty.com / Admin@1234');
    }
}
