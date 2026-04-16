<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            AdminUserSeeder::class,
            SettingsSeeder::class,
            NavigationSeeder::class,
            BranchSeeder::class,
            BrandSeeder::class,
            SamplePagesSeeder::class,
            BlogSeeder::class,
            ProductSeeder::class,
            CatalogSeeder::class,
        ]);
    }
}
