<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'masculino' => ['name' => 'Masculino', 'sort_order' => 0],
            'femenino' => ['name' => 'Femenino', 'sort_order' => 1],
            'calzado' => ['name' => 'Calzado', 'sort_order' => 2],
            'accesorios' => ['name' => 'Accesorios', 'sort_order' => 3],
        ];
        $catIds = [];
        foreach ($categories as $slug => $data) {
            $cat = ProductCategory::updateOrCreate(['slug' => $slug], $data + ['slug' => $slug]);
            $catIds[$slug] = $cat->id;
        }

        $products = [
            [
                'slug' => 'campera-case-ih-negro-masculino',
                'name' => 'Campera Case IH Negro',
                'category' => 'masculino',
                'image' => 'assets/images/redcaseih/camperacaseihnegromasculino.jpg',
                'description' => "Campera oficial Case IH en color negro para hombre.\nMaterial resistente pensado para el campo y el día a día. Logo bordado.",
            ],
            [
                'slug' => 'campera-case-ih-rojo-femenino',
                'name' => 'Campera Case IH Rojo',
                'category' => 'femenino',
                'image' => 'assets/images/redcaseih/camperacaseiihrojofemenino.jpg',
                'description' => "Campera oficial Case IH en el icónico rojo, corte femenino.\nAbrigo liviano con logo bordado y detalles de la marca.",
            ],
            [
                'slug' => 'campera-puma-case-ih-masculino',
                'name' => 'Campera Puma Case IH',
                'category' => 'masculino',
                'image' => 'assets/images/redcaseih/camperapumacasihmasculino.jpg',
                'description' => "Campera Puma edición especial Case IH para hombre.\nDiseño deportivo con la colaboración oficial entre ambas marcas.",
            ],
            [
                'slug' => 'chaleco-case-ih-masculino',
                'name' => 'Chaleco Case IH',
                'category' => 'masculino',
                'image' => 'assets/images/redcaseih/chalecomasculino.jpg',
                'description' => "Chaleco oficial Case IH para hombre.\nIdeal para días frescos en el campo, con múltiples bolsillos funcionales.",
            ],
            [
                'slug' => 'remera-polo-case-ih-femenino',
                'name' => 'Remera Polo Case IH',
                'category' => 'femenino',
                'image' => 'assets/images/redcaseih/remerapolocaseihfemenino.jpg',
                'description' => "Remera polo oficial Case IH corte femenino.\nMaterial de algodón premium con logo bordado en el pecho.",
            ],
            [
                'slug' => 'bota-case-ih-masculina',
                'name' => 'Bota Case IH',
                'category' => 'masculino',
                'image' => 'assets/images/redcaseih/botamasculina.jpg',
                'description' => "Bota de trabajo Case IH para hombre.\nCuero resistente, suela antideslizante y acabado con detalles de la marca.",
            ],
            [
                'slug' => 'botas-case-ih',
                'name' => 'Botas Case IH',
                'category' => 'calzado',
                'image' => 'assets/images/redcaseih/botascaseih.jpg',
                'description' => "Botas Case IH para el campo.\nDiseño clásico, construcción robusta y rendimiento probado en todo terreno.",
            ],
            [
                'slug' => 'gorra-case-ih',
                'name' => 'Gorra Case IH',
                'category' => 'accesorios',
                'image' => 'assets/images/redcaseih/bocamasculina2.jpg',
                'description' => "Gorra oficial Case IH.\nLogo bordado, cierre ajustable y material de alta calidad.",
            ],
            [
                'slug' => 'gorra-case-ih-negra',
                'name' => 'Gorra Case IH Negra',
                'category' => 'accesorios',
                'image' => 'assets/images/redcaseih/bocamasculina3.jpg',
                'description' => "Gorra oficial Case IH en negro.\nEstilo sobrio y el clásico logo rojo bordado.",
            ],
            [
                'slug' => 'termo-stanley-case-ih',
                'name' => 'Termo Stanley Case IH',
                'category' => 'accesorios',
                'image' => 'assets/images/redcaseih/termostanleyparamate.jpg',
                'description' => "Termo Stanley edición Case IH para mate.\nAcero inoxidable, doble pared al vacío y el inconfundible rojo Case IH.",
            ],
        ];

        foreach ($products as $i => $p) {
            Product::updateOrCreate(
                ['slug' => $p['slug']],
                [
                    'name' => $p['name'],
                    'description' => $p['description'],
                    'product_category_id' => $catIds[$p['category']],
                    'image' => $p['image'],
                    'images' => [],
                    'whatsapp_message' => 'Hola, me interesa este producto: ' . $p['name'],
                    'is_active' => true,
                    'sort_order' => $i,
                ]
            );
        }

        // Clean up legacy seed data
        Product::whereNotIn('slug', array_column($products, 'slug'))->delete();
        ProductCategory::whereNotIn('slug', array_keys($categories))
            ->whereDoesntHave('products')
            ->delete();
    }
}
