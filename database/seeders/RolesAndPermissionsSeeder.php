<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'pages.view', 'pages.create', 'pages.edit', 'pages.delete',
            'blocks.manage',
            'navigation.manage',
            'media.view', 'media.upload', 'media.delete',
            'branches.view', 'branches.create', 'branches.edit', 'branches.delete',
            'brands.view', 'brands.create', 'brands.edit', 'brands.delete',
            'products.view', 'products.create', 'products.edit', 'products.delete',
            'orders.view', 'orders.manage',
            'contacts.view', 'contacts.manage',
            'blog.view', 'blog.create', 'blog.edit', 'blog.delete',
            'seo.manage',
            'settings.manage',
            'users.view', 'users.create', 'users.edit', 'users.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $superAdmin = Role::firstOrCreate(['name' => 'super-admin']);

        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->syncPermissions($permissions);

        $editor = Role::firstOrCreate(['name' => 'editor']);
        $editor->syncPermissions([
            'pages.view', 'pages.create', 'pages.edit',
            'blocks.manage',
            'navigation.manage',
            'media.view', 'media.upload',
            'branches.view',
            'brands.view',
            'blog.view', 'blog.create', 'blog.edit',
            'seo.manage',
        ]);

        $storeManager = Role::firstOrCreate(['name' => 'store-manager']);
        $storeManager->syncPermissions([
            'products.view', 'products.create', 'products.edit', 'products.delete',
            'orders.view', 'orders.manage',
            'brands.view', 'brands.create', 'brands.edit',
            'media.view', 'media.upload',
        ]);
    }
}
