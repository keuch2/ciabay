<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\CatalogCategory;
use App\Models\CatalogProduct;
use Illuminate\Database\Seeder;

class CatalogSeeder extends Seeder
{
    /**
     * Seeds an example Case IH catalog so admins can see a populated flow
     * on a fresh install. Reuses the existing `caseih` brand from BrandSeeder.
     * Idempotent: uses updateOrCreate keyed on (brand_id, slug).
     */
    public function run(): void
    {
        $brand = Brand::where('slug', 'case-ih')->first();
        if (! $brand) return;

        $brand->update([
            'catalog_enabled' => true,
            'catalog_hero_image' => 'assets/images/hero_principal.jpg',
            'catalog_intro' => 'La línea completa Case IH distribuida por Ciabay: tractores, cosechadoras, pulverizadoras y plantadoras para cada etapa del cultivo. Consultá con un asesor por las opciones disponibles y financiación.',
            'catalog_contact_whatsapp' => null, // fall back to global whatsapp_number setting
            'catalog_contact_message' => "Hola, me interesa el {producto} del catálogo Case IH.\n{url}",
        ]);

        $categories = [
            ['slug' => 'tractores', 'name' => 'Tractores', 'description' => 'Potencia, confort y tecnología para cada tarea del campo.', 'sort_order' => 0],
            ['slug' => 'cosechadoras', 'name' => 'Cosechadoras', 'description' => 'Eficiencia de trilla y separación para maximizar el rendimiento.', 'sort_order' => 1],
            ['slug' => 'pulverizadoras', 'name' => 'Pulverizadoras', 'description' => 'Aplicación precisa para proteger y nutrir tu cultivo.', 'sort_order' => 2],
            ['slug' => 'plantadoras', 'name' => 'Plantadoras', 'description' => 'Siembra uniforme con control de población y profundidad.', 'sort_order' => 3],
        ];

        $catIds = [];
        foreach ($categories as $data) {
            $cat = CatalogCategory::updateOrCreate(
                ['brand_id' => $brand->id, 'slug' => $data['slug']],
                $data + ['brand_id' => $brand->id, 'is_active' => true]
            );
            $catIds[$data['slug']] = $cat->id;
        }

        $products = [
            // Tractores
            [
                'category' => 'tractores',
                'slug' => 'magnum-340',
                'name' => 'Magnum 340',
                'short' => 'El tractor de alta potencia más productivo de su clase.',
                'desc' => "Motor FPT Cursor 9 de 340 HP con turbo intercooler.\nTransmisión Full Powershift de 18 velocidades con control automático.\nSistema hidráulico CCLS con caudal de 162 L/min.\nCabina SurroundVision con aislamiento acústico de primera línea.",
                'image' => 'assets/images/hero_prinicipal2.jpg',
            ],
            [
                'category' => 'tractores',
                'slug' => 'puma-185',
                'name' => 'Puma 185',
                'short' => 'Versatilidad y potencia para trabajos de campo medianos a pesados.',
                'desc' => "Motor FPT de 185 HP. Transmisión CVT o Powershift según configuración.\nCabina con suspensión mecánica y visibilidad panorámica.\nHidráulica de alto caudal para implementos exigentes.",
                'image' => 'assets/images/camperascase.jpg',
            ],
            [
                'category' => 'tractores',
                'slug' => 'farmall-110a',
                'name' => 'Farmall 110A',
                'short' => 'Simplicidad, robustez y bajo costo operativo.',
                'desc' => "Motor FPT de 110 HP, ideal para pequeñas y medianas explotaciones.\nTransmisión sincronizada 12x12. Toma de fuerza de 540/1000 RPM.\nHidráulica abierta con capacidad para los implementos más comunes.",
                'image' => 'assets/images/maquina.jpg',
            ],
            // Cosechadoras
            [
                'category' => 'cosechadoras',
                'slug' => 'axial-flow-9250',
                'name' => 'Axial-Flow 9250',
                'short' => 'La línea Axial-Flow reinventada: más capacidad, menos pérdidas.',
                'desc' => "Motor FPT Cursor 16 de 625 HP.\nSistema rotor de flujo axial mono-rotor, el más reconocido del mercado.\nTolva de 14.400 litros con descarga rápida.\nTecnología AFS Harvest Command automatiza los ajustes críticos en tiempo real.",
                'image' => 'assets/images/hero_principal.jpg',
            ],
            [
                'category' => 'cosechadoras',
                'slug' => 'axial-flow-4150',
                'name' => 'Axial-Flow 4150',
                'short' => 'Cosechadora mediana con la tecnología Axial-Flow que conocés.',
                'desc' => "Motor de 268 HP. Tolva de 6.800 litros. Sistema Axial-Flow de flujo continuo, ideal para explotaciones de mediana escala.",
                'image' => 'assets/images/hero_prinicipal-mobile.jpg',
            ],
            // Pulverizadoras
            [
                'category' => 'pulverizadoras',
                'slug' => 'patriot-250',
                'name' => 'Patriot 250',
                'short' => 'Pulverizadora autopropulsada de alta performance.',
                'desc' => "Tanque de 2.500 litros. Barra de 24 a 36 metros.\nSistema de control de secciones AIM Command con corte automático.\nSuspensión neumática independiente en las 4 ruedas.",
                'image' => 'assets/images/hero_ejemplo.jpg',
            ],
            [
                'category' => 'pulverizadoras',
                'slug' => 'patriot-150',
                'name' => 'Patriot 150',
                'short' => 'Modelo compacto ideal para lotes medianos.',
                'desc' => "Tanque de 1.500 litros. Barra de 21 a 24 metros.\nMonitor AFS Pro 700 con GPS y control automático de secciones.",
                'image' => 'assets/images/hero_prinicipal2-mobile.jpg',
            ],
            // Plantadoras
            [
                'category' => 'plantadoras',
                'slug' => 'early-riser-2150',
                'name' => 'Early Riser 2150',
                'short' => 'Plantadora de alta precisión para siembra directa.',
                'desc' => "Unidades de siembra de doble disco con sistema de nivelación activo.\nDosificación electrónica vSet con monitor AFS.\nConfiguraciones desde 13 hasta 32 filas.",
                'image' => 'assets/images/historia.jpg',
            ],
        ];

        foreach ($products as $i => $p) {
            $catalogProduct = CatalogProduct::updateOrCreate(
                ['brand_id' => $brand->id, 'slug' => $p['slug']],
                [
                    'brand_id' => $brand->id,
                    'catalog_category_id' => $catIds[$p['category']],
                    'name' => $p['name'],
                    'short_description' => $p['short'],
                    'description' => $p['desc'],
                    'image' => $p['image'],
                    'images' => [],
                    'contact_enabled' => true,
                    'is_active' => true,
                    'sort_order' => $i,
                ]
            );
            $catalogProduct->categories()->sync([$catIds[$p['category']]]);
        }
    }
}
