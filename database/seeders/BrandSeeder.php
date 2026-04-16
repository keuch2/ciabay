<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        if (Brand::count() > 0) return;

        $brands = [
            ['name' => 'Case IH', 'slug' => 'case-ih', 'description' => 'Líder mundial en maquinaria agrícola', 'website_url' => 'https://www.caseih.com', 'is_represented' => true, 'sort_order' => 0],
            ['name' => 'Stara', 'slug' => 'stara', 'description' => 'Pulverizadoras y sembradoras de alta tecnología', 'website_url' => 'https://www.stara.com.br', 'is_represented' => true, 'sort_order' => 1],
            ['name' => 'Trimble', 'slug' => 'trimble', 'description' => 'Tecnología de agricultura de precisión', 'website_url' => 'https://agriculture.trimble.com', 'is_represented' => true, 'sort_order' => 2],
            ['name' => 'Shell', 'slug' => 'shell', 'description' => 'Lubricantes y productos para maquinaria', 'website_url' => 'https://www.shell.com.py', 'is_represented' => true, 'sort_order' => 3],
            ['name' => 'Baldan', 'slug' => 'baldan', 'description' => 'Implementos agrícolas de calidad', 'website_url' => 'https://www.baldan.com.br', 'is_represented' => true, 'sort_order' => 4],
            ['name' => 'Jacto', 'slug' => 'jacto', 'description' => 'Pulverizadoras y equipos de aplicación', 'website_url' => 'https://www.jacto.com', 'is_represented' => true, 'sort_order' => 5],
        ];

        foreach ($brands as $brand) {
            Brand::create(array_merge($brand, ['is_active' => true]));
        }
    }
}
