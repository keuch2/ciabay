<?php

namespace Database\Seeders;

use App\Models\Navigation;
use App\Models\NavigationItem;
use Illuminate\Database\Seeder;

class NavigationSeeder extends Seeder
{
    public function run(): void
    {
        // Header Navigation
        $header = Navigation::firstOrCreate(
            ['location' => 'header'],
            ['name' => 'Menú Principal']
        );

        if ($header->allItems()->count() === 0) {
            $sobre = NavigationItem::create([
                'navigation_id' => $header->id,
                'label' => 'SOBRE CIABAY',
                'url' => '/historia',
                'target' => '_self',
                'sort_order' => 0,
            ]);

            NavigationItem::create([
                'navigation_id' => $header->id,
                'parent_id' => $sobre->id,
                'label' => 'Historia',
                'url' => '/historia',
                'target' => '_self',
                'sort_order' => 0,
            ]);

            NavigationItem::create([
                'navigation_id' => $header->id,
                'parent_id' => $sobre->id,
                'label' => 'Misión, Visión y Valores',
                'url' => '/mision-vision-valores',
                'target' => '_self',
                'sort_order' => 1,
            ]);

            $unidades = NavigationItem::create([
                'navigation_id' => $header->id,
                'label' => 'UNIDADES DE NEGOCIO',
                'url' => '#',
                'target' => '_self',
                'sort_order' => 1,
            ]);

            foreach (['Maquinaria' => '/maquinaria', 'Implementos' => '/implementos', 'Insumos' => '/insumos', 'Agricultura de Precisión' => '/agricultura-de-precision', 'Postventa' => '/postventa'] as $label => $url) {
                NavigationItem::create([
                    'navigation_id' => $header->id,
                    'parent_id' => $unidades->id,
                    'label' => $label,
                    'url' => $url,
                    'target' => '_self',
                    'sort_order' => 0,
                ]);
            }

            NavigationItem::create([
                'navigation_id' => $header->id,
                'label' => 'SUCURSALES',
                'url' => '/sucursales',
                'target' => '_self',
                'sort_order' => 2,
            ]);

            NavigationItem::create([
                'navigation_id' => $header->id,
                'label' => 'USADOS',
                'url' => 'https://www.ciabayusados.com',
                'target' => '_blank',
                'sort_order' => 3,
            ]);

            NavigationItem::create([
                'navigation_id' => $header->id,
                'label' => 'CONTACTO',
                'url' => '/contacto',
                'target' => '_self',
                'sort_order' => 4,
            ]);
        }

        // Footer Navigation
        $footer = Navigation::firstOrCreate(
            ['location' => 'footer'],
            ['name' => 'Footer']
        );

        if ($footer->allItems()->count() === 0) {
            $col1 = NavigationItem::create([
                'navigation_id' => $footer->id,
                'label' => 'Empresa',
                'url' => '#',
                'target' => '_self',
                'sort_order' => 0,
            ]);

            foreach (['Historia' => '/historia', 'Misión y Valores' => '/mision-vision-valores', 'Sucursales' => '/sucursales'] as $label => $url) {
                NavigationItem::create([
                    'navigation_id' => $footer->id,
                    'parent_id' => $col1->id,
                    'label' => $label,
                    'url' => $url,
                    'target' => '_self',
                    'sort_order' => 0,
                ]);
            }

            $col2 = NavigationItem::create([
                'navigation_id' => $footer->id,
                'label' => 'Servicios',
                'url' => '#',
                'target' => '_self',
                'sort_order' => 1,
            ]);

            foreach (['Maquinaria' => '/maquinaria', 'Implementos' => '/implementos', 'Insumos' => '/insumos', 'Postventa' => '/postventa'] as $label => $url) {
                NavigationItem::create([
                    'navigation_id' => $footer->id,
                    'parent_id' => $col2->id,
                    'label' => $label,
                    'url' => $url,
                    'target' => '_self',
                    'sort_order' => 0,
                ]);
            }

            $col3 = NavigationItem::create([
                'navigation_id' => $footer->id,
                'label' => 'Contacto',
                'url' => '#',
                'target' => '_self',
                'sort_order' => 2,
            ]);

            NavigationItem::create([
                'navigation_id' => $footer->id,
                'parent_id' => $col3->id,
                'label' => 'Formulario de Contacto',
                'url' => '/contacto',
                'target' => '_self',
                'sort_order' => 0,
            ]);
            NavigationItem::create([
                'navigation_id' => $footer->id,
                'parent_id' => $col3->id,
                'label' => 'Trabaja en Ciabay',
                'url' => 'https://grupo.ciabay.com/trabajaenciabay',
                'target' => '_blank',
                'sort_order' => 1,
            ]);
            NavigationItem::create([
                'navigation_id' => $footer->id,
                'parent_id' => $col3->id,
                'label' => 'Usados',
                'url' => 'https://www.ciabayusados.com',
                'target' => '_blank',
                'sort_order' => 2,
            ]);
        }
    }
}
