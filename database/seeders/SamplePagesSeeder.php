<?php

namespace Database\Seeders;

use App\Models\Block;
use App\Models\Page;
use Illuminate\Database\Seeder;

class SamplePagesSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedHomepage();
        $this->seedHistoria();
        $this->seedMisionVisionValores();
        $this->seedSucursales();
        $this->seedMaquinaria();
        $this->seedImplementos();
        $this->seedInsumos();
        $this->seedAgriculturaPrecision();
        $this->seedPostventa();
        $this->seedContacto();
        $this->seedTiendaOnline();
    }

    private function page(string $slug, array $attributes): Page
    {
        return Page::updateOrCreate(['slug' => $slug], $attributes + ['slug' => $slug, 'template' => null]);
    }

    private function resetBlocks(Page $page, array $blocks): void
    {
        $page->blocks()->delete();
        foreach ($blocks as $i => $block) {
            Block::create([
                'page_id' => $page->id,
                'type' => $block['type'],
                'sort_order' => $i,
                'data' => $block['data'],
            ]);
        }
    }

    private function seedHomepage(): void
    {
        $page = $this->page('inicio', [
            'title' => 'Inicio',
            'is_homepage' => true,
            'status' => 'published',
            'meta_title' => 'Ciabay - Agricultura en buenas manos | Maquinaria Agrícola Case IH Paraguay',
            'meta_description' => 'Distribuidores oficiales de maquinaria agrícola Case IH en Paraguay. Más de 31 años de experiencia, 8 sucursales y 300+ colaboradores.',
            'sort_order' => 0,
        ]);

        $this->resetBlocks($page, [
            ['type' => 'hero-carousel', 'data' => [
                'slides' => [
                    ['image' => 'assets/images/hero_principal.jpg', 'mobile_image' => 'assets/images/hero_prinicipal-mobile.jpg', 'alt' => 'Ciabay - Agricultura en buenas manos', 'title' => '', 'subtitle' => '', 'button_text' => '', 'button_url' => ''],
                    ['image' => 'assets/images/hero_prinicipal2.jpg', 'mobile_image' => 'assets/images/hero_prinicipal2-mobile.jpg', 'alt' => 'Ciabay - Soluciones agrícolas', 'title' => '', 'subtitle' => '', 'button_text' => '', 'button_url' => ''],
                ],
            ]],
            ['type' => 'stats-grid', 'data' => [
                'title' => 'CONFIANZA RESPALDADA POR RESULTADOS',
                'stats' => [
                    ['number' => '+31', 'label' => 'AÑOS'],
                    ['number' => '+300', 'label' => 'COLABORADORES'],
                    ['number' => '08', 'label' => 'SUCURSALES'],
                    ['number' => '+120', 'label' => "TÉCNICOS DE\nPOST VENTA"],
                ],
            ]],
            ['type' => 'unidades-negocio', 'data' => [
                'title' => 'Unidades de Negocio',
                'items' => [
                    ['title' => 'Máquinas', 'alt' => 'Máquinas', 'image' => 'assets/images/unidades/MAQUINAS.png', 'url' => 'maquinaria'],
                    ['title' => 'Implementos', 'alt' => 'Implementos', 'image' => 'assets/images/unidades/IMPLEMENTOS.png', 'url' => 'implementos'],
                    ['title' => 'Insumos', 'alt' => 'Insumos', 'image' => 'assets/images/unidades/INSUMOS.png', 'url' => 'insumos'],
                    ['title' => 'Postventa', 'alt' => 'Postventa', 'image' => 'assets/images/unidades/POSTVENTAS.png', 'url' => 'postventa'],
                ],
            ]],
            ['type' => 'cta-section', 'data' => [
                'variant' => 'default',
                'title' => "Más fuerte, más preparado,\ncon CIABAY a tu lado",
            ]],
            ['type' => 'brands-grid', 'data' => [
                'title' => 'MARCAS REPRESENTADAS',
                'brands' => $this->brandList(),
            ]],
            ['type' => 'agriculture-title', 'data' => [
                'title' => 'No estás solo. Contás con las mejores marcas del mercado, y con una empresa que te acompaña.',
            ]],
            ['type' => 'agriculture-image', 'data' => [
                'background_image' => 'assets/images/maquina.jpg',
                'background_alt' => 'Agricultor',
                'overlay_image' => 'assets/images/agricultura.png',
                'overlay_alt' => 'Agricultura en buenas manos',
            ]],
        ]);
    }

    private function seedHistoria(): void
    {
        $page = $this->page('historia', [
            'title' => 'Historia',
            'status' => 'published',
            'meta_title' => 'Historia de Ciabay | Más de 30 años de trayectoria',
            'meta_description' => 'Conocé la historia de Ciabay: agricultura en buenas manos desde 1995, con el productor paraguayo.',
            'sort_order' => 1,
        ]);

        $this->resetBlocks($page, [
            ['type' => 'page-hero', 'data' => [
                'variant' => 'historia',
                'title' => '',
                'subtitle' => '',
                'image' => 'assets/images/historia.jpg',
                'buttons' => [],
            ]],
            ['type' => 'intro-banner', 'data' => [
                'variant' => 'historia',
                'title' => 'CIABAY: Agricultura en buenas manos',
                'text' => 'Hace 30 años acompañamos al agro paraguayo con una propuesta integral, construida sobre experiencia, cercanía y compromiso. Crecemos con el productor, aportando soluciones que suman valor desde la planificación hasta los resultados.',
            ]],
            ['type' => 'narrative-paragraphs', 'data' => [
                'variant' => 'historia',
                'title' => 'Nuestra historia en el agro paraguayo',
                'paragraphs' => [
                    ['text' => 'A finales de la década del 70, Don Oscar Lourenço llegó a Paraguay y comenzó su trayectoria en el comercio de granos. Con visión y esfuerzo, fundó Silo Amambay, una de las principales acopiadoras y comercializadoras de granos del país, marcando el inicio de un legado en el sector agrícola.'],
                    ['text' => 'Hoy, ese legado sigue vivo con el trabajo de muchas personas que, día a día, sostienen la misma convicción: hacer las cosas bien y estar cerca del productor.'],
                ],
                'caption' => 'Oscar Lourenço y Vladimir Pesenti, parte fundamental de nuestros orígenes.',
            ]],
            ['type' => 'timeline', 'data' => [
                'variant' => 'historia',
                'title' => 'Línea de Tiempo',
                'events' => [
                    ['year' => '1995', 'title' => '', 'description' => 'Nace Ciabay S.A. con el propósito de ofrecer una solución integral al productor paraguayo.', 'image' => 'assets/images/lineadetiempo/1995.png'],
                    ['year' => '2000', 'title' => '', 'description' => 'Reforzamos nuestra identidad comercial, consolidando presencia y confianza.', 'image' => 'assets/images/lineadetiempo/2000.png'],
                    ['year' => '2008', 'title' => '', 'description' => 'Avanzamos en una modernización de marca con iconografía agrícola, reflejando evolución y cercanía.', 'image' => 'assets/images/lineadetiempo/2008.png'],
                    ['year' => '2018', 'title' => '', 'description' => 'Presentamos nuestra identidad actual, reflejando innovación y proyección.', 'image' => 'assets/images/lineadetiempo/2018.png'],
                    ['year' => '2025', 'title' => '', 'description' => 'Cumplimos 30 años en el mercado, reafirmando nuestro compromiso con el agro paraguayo.', 'image' => 'assets/images/lineadetiempo/2025.png'],
                ],
            ]],
            ['type' => 'pillars', 'data' => [
                'variant' => 'direccionadores',
                'title' => 'Direccionadores',
                'pillars' => [
                    ['title' => 'Misión', 'text' => 'Proveer un conjunto de soluciones sostenibles para las necesidades del agricultor.', 'icon_svg' => '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>', 'icon_stroke' => '2'],
                    ['title' => 'Visión', 'text' => 'Ser reconocido por el agricultor como la mejor opción integral para su negocio.', 'icon_svg' => '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>', 'icon_stroke' => '2'],
                ],
            ]],
            ['type' => 'value-grid', 'data' => [
                'variant' => 'historia',
                'title' => 'Valores',
                'items' => [
                    ['label' => 'Proactividad', 'icon_svg' => '<polyline points="13 17 18 12 13 7"/><polyline points="6 17 11 12 6 7"/>', 'icon_stroke' => '2'],
                    ['label' => 'Integridad', 'icon_svg' => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>', 'icon_stroke' => '2'],
                    ['label' => 'Empatía', 'icon_svg' => '<path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>', 'icon_stroke' => '2'],
                    ['label' => 'Transparencia', 'icon_svg' => '<rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/>', 'icon_stroke' => '2'],
                    ['label' => 'Orientado a resultados', 'icon_svg' => '<polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>', 'icon_stroke' => '2'],
                    ['label' => 'Cliente satisfecho', 'icon_svg' => '<path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"/>', 'icon_stroke' => '2'],
                ],
            ]],
        ]);
    }

    private function seedMisionVisionValores(): void
    {
        $page = $this->page('mision-vision-valores', [
            'title' => 'Misión, Visión y Valores',
            'status' => 'published',
            'meta_title' => 'Misión, Visión y Valores | Ciabay',
            'meta_description' => 'Los principios que guían nuestro compromiso con el agro paraguayo.',
            'sort_order' => 2,
        ]);

        $this->resetBlocks($page, [
            ['type' => 'page-hero', 'data' => [
                'variant' => 'mvv',
                'title' => 'Misión, Visión y Valores',
                'subtitle' => 'Los principios que guían nuestro compromiso con el agro paraguayo',
                'image' => 'assets/images/hero_ejemplo.jpg',
            ]],
            ['type' => 'pillars', 'data' => [
                'variant' => 'mvv-pillars',
                'title' => '',
                'pillars' => [
                    ['title' => 'Visión', 'modifier' => 'vision', 'text' => 'Ser, por excelencia, la empresa más completa en soluciones, tecnología y atención al agronegocio en Paraguay, destacándose por su capital humano y por la relación con clientes y proveedores.', 'icon_svg' => '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>', 'icon_stroke' => '1.5'],
                    ['title' => 'Misión', 'modifier' => 'mision', 'text' => 'Ofrecer seguridad, asistencia, compañerismo y fidelidad al hombre de campo, enfocados siempre en el crecimiento conjunto, valorando la honestidad y el carácter.', 'icon_svg' => '<circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/>', 'icon_stroke' => '1.5'],
                ],
            ]],
            ['type' => 'value-grid', 'data' => [
                'variant' => 'mvv',
                'title' => 'Nuestros Valores',
                'items' => [
                    ['label' => 'Ética Empresarial', 'icon_svg' => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>', 'icon_stroke' => '1.5'],
                    ['label' => 'Responsabilidad Social', 'icon_svg' => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>', 'icon_stroke' => '1.5'],
                    ['label' => 'Honestidad', 'icon_svg' => '<path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>', 'icon_stroke' => '1.5'],
                    ['label' => 'Transparencia', 'icon_svg' => '<rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>', 'icon_stroke' => '1.5'],
                ],
            ]],
            ['type' => 'callout-card', 'data' => [
                'variant' => 'mvv',
                'title' => 'Nuestro Objetivo',
                'text' => 'Ciabay es una empresa que busca constantemente ofrecer <strong>soluciones tecnológicas</strong> en el campo.',
                'icon_svg' => '<circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/>',
                'icon_stroke' => '1.5',
            ]],
        ]);
    }

    private function seedSucursales(): void
    {
        $page = $this->page('sucursales', [
            'title' => 'Sucursales',
            'status' => 'published',
            'meta_title' => 'Sucursales Ciabay | 8 Sucursales en Paraguay',
            'meta_description' => 'Encontrá la sucursal Ciabay más cercana. 8 puntos de venta y servicio técnico en todo Paraguay.',
            'sort_order' => 3,
        ]);

        $this->resetBlocks($page, [
            ['type' => 'page-hero', 'data' => [
                'variant' => 'default',
                'title' => 'Sucursales',
                'subtitle' => '',
                'image' => 'assets/images/sucursales/GENERAL.png',
            ]],
            ['type' => 'branches-cards', 'data' => [
                'source' => 'branches',
                'title' => 'Nuestras Sucursales',
                'subtitle' => 'Estamos presentes en las principales zonas productivas del país',
            ]],
            ['type' => 'map-embed', 'data' => [
                'title' => 'Ubicaciones',
                'subtitle' => 'Todas nuestras sucursales en el mapa',
                'embed_url' => 'https://www.google.com/maps/d/embed?mid=1nncawIUf6Qdq0dHxqjiJW1kqfmtpUvc&ehbc=2E312F',
                'height' => '600',
            ]],
        ]);
    }

    private function seedMaquinaria(): void
    {
        $page = $this->page('maquinaria', [
            'title' => 'Maquinaria',
            'status' => 'published',
            'meta_title' => 'Maquinaria Agrícola Case IH | Ciabay Paraguay',
            'meta_description' => 'Tractores, cosechadoras y equipos Case IH. La mejor tecnología para tu campo.',
            'sort_order' => 4,
        ]);

        $this->resetBlocks($page, [
            ['type' => 'page-hero', 'data' => [
                'variant' => 'default',
                'title' => 'Maquinaria',
                'image' => 'assets/images/hero_principal.jpg',
            ]],
            ['type' => 'callout-card', 'data' => [
                'variant' => 'default',
                'title' => 'Sección en desarrollo',
                'text' => 'Estamos trabajando en esta página. Pronto estará disponible con toda la información sobre nuestra línea de maquinaria Case IH.',
            ]],
        ]);
    }

    private function seedImplementos(): void
    {
        $page = $this->page('implementos', [
            'title' => 'Implementos',
            'status' => 'published',
            'meta_title' => 'Implementos Agrícolas | Ciabay Paraguay',
            'meta_description' => 'El socio ideal para tu tractor. La línea más completa de implementos con el respaldo de las marcas líderes del mercado.',
            'sort_order' => 5,
        ]);

        $this->resetBlocks($page, [
            ['type' => 'page-hero', 'data' => [
                'variant' => 'impl',
                'title' => 'El socio ideal para tu tractor.',
                'subtitle' => 'Convertí la potencia en trabajo real. Tenemos la línea más completa de implementos para cada etapa de tu cultivo, con el respaldo de las marcas líderes del mercado.',
                'image' => 'assets/images/hero_ejemplo.jpg',
                'buttons' => [
                    ['text' => 'Ver Catálogo Completo', 'url' => '#catalogo', 'style' => 'primary', 'target' => '_self'],
                ],
            ]],
            ['type' => 'intro-banner', 'data' => [
                'variant' => 'impl',
                'title' => 'Todo lo que tu campo necesita, en un solo lugar.',
                'text' => 'Sabemos que armar el equipo perfecto lleva tiempo. En <strong>CIABAY</strong> te lo hacemos fácil. Ya sea para preparar el suelo, sembrar con precisión o transportar la cosecha, acá encontrás el implemento exacto para la potencia de tu tractor y las condiciones de tu terreno. No pierdas tiempo tratando con múltiples proveedores; <strong>centralizá tu flota con nosotros</strong>.',
            ]],
            ['type' => 'brand-showcase', 'data' => [
                'anchor_id' => 'catalogo',
                'title' => 'Nuestras Marcas Líderes',
                'subtitle' => 'El sello de calidad que respalda cada implemento',
                'brands' => [
                    ['slug' => 'tatu', 'name' => 'Tatu Marchesan', 'logo' => 'assets/images/marcas/tatumarchesan.png', 'tagline' => 'El Rey del Suelo', 'description' => 'Sinónimo de resistencia en Paraguay. Desde rastras hasta sembradoras, Tatu ofrece la robustez necesaria para enfrentar nuestros suelos más pesados. Simplicidad operativa y alto valor de reventa.', 'products' => ['Rastras','Sembradoras','Niveladoras'], 'cta_text' => 'Ver productos Tatu', 'cta_url' => 'contacto'],
                    ['slug' => 'vencetudo', 'name' => 'Vence Tudo', 'logo' => 'assets/images/marcas/vencetudo.png', 'tagline' => 'Especialistas en Cosecha', 'description' => 'Si hacés maíz, conocés la "Bocuda". Representamos a la marca líder en plataformas maiceras y sembradoras, reconocida por su capacidad de entregar una cosecha limpia y reducir pérdidas.', 'products' => ['Plataformas Maiceras (Bocuda)','Sembradoras'], 'cta_text' => 'Ver productos Vence Tudo', 'cta_url' => 'contacto'],
                    ['slug' => 'macdon', 'name' => 'MacDon', 'logo' => 'assets/images/marcas/macdon.png', 'tagline' => 'Tecnología de Corte Superior', 'description' => 'Maximiza el rendimiento de tu cosechadora Case IH. MacDon es el líder mundial en tecnología Draper, permitiendo una alimentación fluida y constante, incluso en los cultivos más densos o húmedos.', 'products' => ['Plataformas Draper','Segadoras'], 'cta_text' => 'Ver productos MacDon', 'cta_url' => 'contacto'],
                    ['slug' => 'jan', 'name' => 'Jan', 'logo' => 'assets/images/marcas/jan.png', 'tagline' => 'Innovación en Siembra', 'description' => 'Tecnología brasileña de punta para siembra de precisión. JAN ofrece sembradoras con sistemas avanzados de dosificación y distribución para maximizar la germinación y el rendimiento por hectárea.', 'products' => ['Sembradoras','Plantadoras'], 'cta_text' => 'Ver productos Jan', 'cta_url' => 'contacto'],
                ],
            ]],
            ['type' => 'logo-grid', 'data' => [
                'variant' => 'specialized',
                'anchor_id' => 'especializadas',
                'title' => 'Soluciones Especializadas',
                'subtitle' => 'Marcas expertas en su nicho para que no te falte nada',
                'items' => [
                    ['name' => 'Bandeirante', 'logo' => 'assets/images/marcas/bandeirante.png', 'description' => 'Mezcladores y vagones forrajeros'],
                    ['name' => 'Inroda', 'logo' => 'assets/images/marcas/inroda.png', 'description' => 'Desmalezadoras y limpieza de terreno'],
                    ['name' => 'Agross', 'logo' => 'assets/images/marcas/agross.png', 'description' => 'Soluciones de desmalezado'],
                    ['name' => 'King', 'logo' => 'assets/images/marcas/kingimplementos.png', 'description' => 'Herramientas de laboreo'],
                    ['name' => 'Orion', 'logo' => 'assets/images/marcas/orion.png', 'description' => 'Preparación de suelo'],
                    ['name' => 'Penha', 'logo' => 'assets/images/marcas/penha.png', 'description' => 'Cosechadoras de forraje'],
                    ['name' => 'Difere', 'logo' => 'assets/images/marcas/difere.png', 'description' => 'Equipos diversos'],
                ],
            ]],
            ['type' => 'category-grid', 'data' => [
                'anchor_id' => 'tareas',
                'title' => 'Buscá por Necesidad',
                'subtitle' => 'Encontrá el implemento ideal según la tarea que necesitás realizar',
                'items' => [
                    ['title' => 'Preparación de Suelo', 'icon_svg' => '<path d="M2 22h20"/><path d="M6.36 17.4 4 22h16l-2.36-4.6"/><path d="M12 2v5"/><path d="m8 8 4-1 4 1"/><path d="M8 8v4l4 2 4-2V8"/>', 'list' => ['Arados','Rastras','Descompactadores','Niveladoras','Rodillos'], 'cta_text' => 'Ver Productos', 'cta_url' => 'contacto'],
                    ['title' => 'Siembra y Cuidados', 'icon_svg' => '<path d="M12 10a4 4 0 0 0-4 4c0 2.21 1.79 6 4 6s4-3.79 4-6a4 4 0 0 0-4-4z"/><path d="M12 10V2"/><path d="m8 6 4-4 4 4"/>', 'list' => ['Sembradoras','Cultivadores','Pulverizadores de arrastre','Fertilizadoras'], 'cta_text' => 'Ver Productos', 'cta_url' => 'contacto'],
                    ['title' => 'Cosecha', 'icon_svg' => '<path d="M12 2a10 10 0 1 0 10 10"/><path d="M12 12 2 12"/><path d="M12 2v10"/><path d="M22 2 12 12"/>', 'list' => ['Plataformas de corte','Cabezales maiceros','Plataformas Draper','Cosechadoras de forraje'], 'cta_text' => 'Ver Productos', 'cta_url' => 'contacto'],
                    ['title' => 'Logística y Otros', 'icon_svg' => '<rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/>', 'list' => ['Tolvas','Carretas','Remolques','Desmalezadoras'], 'cta_text' => 'Ver Productos', 'cta_url' => 'contacto'],
                ],
            ]],
            ['type' => 'image-text', 'data' => [
                'variant' => 'impl-repuestos',
                'anchor_id' => 'repuestos',
                'tag' => 'REPUESTOS',
                'title' => 'Piezas de desgaste: Mantenete operando.',
                'text' => 'Los implementos son los que más sufren el desgaste por el contacto directo con el suelo. En <strong>CIABAY</strong> tenemos stock permanente de discos, rodamientos, cuchillas y punteras originales para todas estas marcas.',
                'list' => [
                    'Discos de rastra y sembradora',
                    'Rodamientos y bujes',
                    'Cuchillas y punteras',
                    'Repuestos originales de todas las marcas',
                ],
                'image' => 'assets/images/hero_ejemplo.jpg',
                'button_text' => 'Cotizar Repuestos',
                'button_url' => 'contacto',
            ]],
            ['type' => 'cta-section', 'data' => [
                'variant' => 'impl',
                'title' => '¿Dudas sobre compatibilidad?',
                'text' => 'No adivines. Consultá con nuestros especialistas qué implemento se adapta mejor a la potencia hidráulica y motor de tu tractor.',
                'buttons' => [
                    ['text' => 'Hablar con un Asesor', 'url' => 'contacto', 'style' => 'white', 'icon' => 'none', 'target' => '_self'],
                    ['text' => 'WhatsApp', 'url' => 'https://wa.me/595981000000', 'style' => 'whatsapp', 'icon' => 'whatsapp', 'target' => '_blank'],
                ],
            ]],
        ]);
    }

    private function seedInsumos(): void
    {
        $page = $this->page('insumos', [
            'title' => 'Insumos',
            'status' => 'published',
            'meta_title' => 'Insumos Agrícolas | Ciabay Paraguay',
            'meta_description' => 'Semillas, protección de cultivos y nutrición inteligente. Blindá tu inversión con la mejor tecnología.',
            'sort_order' => 6,
        ]);

        $this->resetBlocks($page, [
            ['type' => 'page-hero', 'data' => [
                'variant' => 'insumos',
                'title' => 'Blindá tu inversión con la mejor tecnología para tu campo.',
                'subtitle' => 'Semillas de alto potencial, protección de cultivos y nutrición inteligente. En CIABAY te asesoramos para que saques el máximo rinde a cada hectárea.',
                'image' => 'assets/images/hero_ejemplo.jpg',
                'buttons' => [
                    ['text' => 'Cotizar Insumos', 'url' => '#contacto', 'style' => 'primary', 'target' => '_self'],
                    ['text' => 'Hablar con un Ingeniero', 'url' => 'contacto', 'style' => 'outline-white', 'target' => '_self'],
                ],
            ]],
            ['type' => 'features-grid', 'data' => [
                'variant' => 'insumos-valor',
                'anchor_id' => 'valor',
                'title' => 'Más que productos, soluciones para tu zafra.',
                'subtitle' => 'Sabemos que cada campaña es distinta y que el clima no espera. Por eso, no solo te vendemos el insumo; te entregamos la <strong>logística que necesitás</strong> y el <strong>respaldo técnico</strong> para aplicarlo en el momento justo.',
                'features' => [
                    ['title' => 'Logística Ágil', 'text' => 'Entregas en tu campo o retiro inmediato en sucursal.', 'icon_svg' => '<rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/>'],
                    ['title' => 'Marcas Líderes', 'text' => 'Somos distribuidores oficiales de Bayer, Nidera y más.', 'icon_svg' => '<path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/>'],
                    ['title' => 'Manejo Integrado', 'text' => 'Te ayudamos a rotar principios activos para cuidar tu suelo.', 'icon_svg' => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/>'],
                ],
            ]],
            ['type' => 'category-feature', 'data' => [
                'anchor_id' => 'semillas', 'alt' => true, 'reversed' => false,
                'tag' => 'GENÉTICA', 'tag_color' => 'green', 'cta_color' => 'green',
                'title' => 'Semillas: El inicio de un buen rinde.',
                'text' => 'Trabajamos con híbridos y variedades adaptadas a las diferentes regiones del Paraguay. Ya sea que busques estabilidad o techos productivos altos, tenemos la genética que tu suelo necesita.',
                'chips' => ['Soja','Maíz','Sorgo','Trigo','Arroz'],
                'brands' => ['Nidera Semillas','Nuseed','Agro Santa Rosa'],
                'image' => 'assets/images/hero_ejemplo.jpg',
                'cta_text' => 'Ver catálogo de Semillas', 'cta_url' => 'contacto',
            ]],
            ['type' => 'category-feature', 'data' => [
                'anchor_id' => 'proteccion', 'alt' => false, 'reversed' => true,
                'tag' => 'PROTECCIÓN', 'tag_color' => 'blue', 'cta_color' => 'blue',
                'title' => 'Protección de Cultivos: Tu campo, libre de amenazas.',
                'text' => 'Desde el barbecho hasta la cosecha. Contamos con el portafolio completo para el control de malezas difíciles, plagas y enfermedades. Asegurá la sanidad de tu lote con tecnología de punta.',
                'chips' => ['Herbicidas','Fungicidas','Insecticidas','Tratamiento de Semillas'],
                'brands' => ['Bayer','Envu','Albuz (Boquillas)'],
                'image' => 'assets/images/hero_ejemplo.jpg',
                'cta_text' => 'Ver Defensivos', 'cta_url' => 'contacto',
            ]],
            ['type' => 'category-feature', 'data' => [
                'anchor_id' => 'nutricion', 'alt' => true, 'reversed' => false,
                'tag' => 'NUTRICIÓN', 'tag_color' => 'orange', 'cta_color' => 'orange',
                'title' => 'Nutrición y Calidad de Aplicación.',
                'text' => 'Potenciá la fisiología de tu cultivo y mejorá la eficiencia de tus caldos. Una buena nutrición marca la diferencia en el peso final del grano.',
                'chips' => ['Fertilizantes','Coadyuvantes','Bioestimulantes','Foliares'],
                'brands' => ['Cropfos','TMF','GRAP','Difere','Coopavel'],
                'image' => 'assets/images/hero_ejemplo.jpg',
                'cta_text' => 'Ver Nutrición', 'cta_url' => 'contacto',
            ]],
            ['type' => 'logo-grid', 'data' => [
                'variant' => 'marcas',
                'anchor_id' => 'marcas',
                'title' => 'Nuestros aliados estratégicos.',
                'subtitle' => 'Trabajamos con las marcas que lideran la investigación y desarrollo en el agro global.',
                'items' => [
                    ['name' => 'Bayer', 'logo' => 'assets/images/marcas/bayer.png', 'cta_url' => 'contacto'],
                    ['name' => 'Nidera', 'logo' => 'assets/images/marcas/nidera.png', 'cta_url' => 'contacto'],
                    ['name' => 'Envu', 'logo' => 'assets/images/marcas/envu.png', 'cta_url' => 'contacto'],
                    ['name' => 'Evora', 'logo' => 'assets/images/marcas/evora.png', 'cta_url' => 'contacto'],
                    ['name' => 'Cropfos', 'logo' => 'assets/images/marcas/cropfos.png', 'cta_url' => 'contacto'],
                    ['name' => 'TMF', 'logo' => 'assets/images/marcas/tmf.png', 'cta_url' => 'contacto'],
                    ['name' => 'Agro Santa Rosa', 'logo' => 'assets/images/marcas/agrosantarosa.png', 'cta_url' => 'contacto'],
                    ['name' => 'Grap', 'logo' => 'assets/images/marcas/grap.png', 'cta_url' => 'contacto'],
                ],
            ]],
            ['type' => 'cross-sell', 'data' => [
                'title' => '¿Necesitás repuestos para tu pulverizadora?',
                'text' => 'Para que el insumo funcione, la máquina tiene que estar a punto. Revisá nuestras boquillas Albuz y repuestos para pulverizadoras Case IH y Jacto.',
                'cta_text' => 'Ir a Repuestos de Pulverización →',
                'cta_url' => 'contacto',
                'icon_svg' => '<circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/>',
            ]],
            ['type' => 'cta-section', 'data' => [
                'variant' => 'insumos',
                'title' => 'Planifiquemos juntos tu próxima campaña.',
                'text' => 'No dejes para última hora la compra de tus insumos. Consultanos disponibilidad y precios ahora mismo.',
                'buttons' => [
                    ['text' => 'Contactar por WhatsApp', 'url' => 'https://wa.me/595981000000', 'style' => 'whatsapp', 'icon' => 'whatsapp', 'target' => '_blank'],
                    ['text' => 'Cotizar Campaña', 'url' => 'contacto', 'style' => 'outline-white', 'icon' => 'none', 'target' => '_self'],
                ],
            ]],
        ]);
    }

    private function seedAgriculturaPrecision(): void
    {
        $page = $this->page('agricultura-de-precision', [
            'title' => 'Agricultura de Precisión',
            'status' => 'published',
            'meta_title' => 'Agricultura de Precisión | Ciabay Paraguay',
            'meta_description' => 'Tecnología de precisión para optimizar tu producción agrícola. GPS, pilotos automáticos y más.',
            'sort_order' => 7,
        ]);

        $this->resetBlocks($page, [
            ['type' => 'page-hero', 'data' => [
                'variant' => 'default',
                'title' => 'Agricultura de Precisión',
                'image' => 'assets/images/hero_ejemplo.jpg',
            ]],
            ['type' => 'callout-card', 'data' => [
                'variant' => 'default',
                'title' => 'Sección en desarrollo',
                'text' => 'Estamos trabajando en esta página. Pronto estará disponible con toda la información sobre agricultura de precisión.',
            ]],
        ]);
    }

    private function seedPostventa(): void
    {
        $page = $this->page('postventa', [
            'title' => 'Postventa',
            'status' => 'published',
            'meta_title' => 'Servicio Postventa | Ciabay Paraguay',
            'meta_description' => 'Servicio técnico especializado y repuestos originales Case IH. 120+ técnicos a tu servicio.',
            'sort_order' => 8,
        ]);

        $this->resetBlocks($page, [
            ['type' => 'page-hero', 'data' => [
                'variant' => 'default',
                'title' => 'Postventa',
                'image' => 'assets/images/hero_ejemplo.jpg',
            ]],
            ['type' => 'callout-card', 'data' => [
                'variant' => 'default',
                'title' => 'Sección en desarrollo',
                'text' => 'Estamos trabajando en esta página. Pronto estará disponible con toda la información sobre nuestros servicios de postventa.',
            ]],
        ]);
    }

    private function seedContacto(): void
    {
        $page = $this->page('contacto', [
            'title' => 'Contacto',
            'status' => 'published',
            'meta_title' => 'Contacto | Ciabay Paraguay',
            'meta_description' => 'Contactá con Ciabay. Estamos para ayudarte con cualquier consulta sobre maquinaria agrícola.',
            'sort_order' => 9,
        ]);

        $this->resetBlocks($page, [
            ['type' => 'page-hero', 'data' => [
                'variant' => 'default',
                'title' => 'Contacto',
                'image' => 'assets/images/sucursales/GENERAL.png',
            ]],
            ['type' => 'contact-info', 'data' => [
                'title' => 'Información de Contacto',
                'form_title' => 'Envíanos un Mensaje',
                'address' => 'Supercarretera Km 2,5 — Hernandarias — Alto Paraná — Paraguay',
                'phone' => '+595 631 22335',
                'email' => 'contacto@ciabay.com',
                'hours' => "Lunes a Viernes: 7:00 - 17:00\nSábados: 7:00 - 12:00",
            ]],
        ]);
    }

    private function seedTiendaOnline(): void
    {
        $page = $this->page('tienda-online', [
            'title' => 'Tienda Online',
            'status' => 'published',
            'meta_title' => 'Red Case IH | Tienda Online Ciabay',
            'meta_description' => 'Indumentaria y accesorios oficiales Case IH. El rojo que te acompaña en el campo, ahora también en tu día a día.',
            'sort_order' => 10,
        ]);

        $this->resetBlocks($page, [
            ['type' => 'redcase-hero', 'data' => [
                'title' => 'Red Case IH',
                'subtitle' => 'El rojo que te acompaña en el campo, ahora también en tu día a día.',
                'image' => 'assets/images/redcaseih/hero.jpg',
                'logo' => 'assets/images/redcase-blanco.png',
            ]],
            ['type' => 'redcase-products', 'data' => [
                'title' => 'Nuestros Productos',
                'subtitle' => 'Indumentaria y accesorios oficiales Case IH',
                'source' => 'all',
            ]],
            ['type' => 'redcase-cta', 'data' => [
                'title' => '¿Querés ser parte del mundo Case IH?',
                'text' => 'Consultá disponibilidad y precios de todos nuestros productos oficiales.',
                'button_text' => 'Contactar por WhatsApp',
                'whatsapp_message' => 'Hola, quiero consultar sobre productos Red Case IH',
            ]],
        ]);
    }

    private function brandList(): array
    {
        return [
            ['name' => 'Case IH', 'logo' => 'assets/images/marcas/caseih.png'],
            ['name' => 'Bayer', 'logo' => 'assets/images/marcas/bayer.png'],
            ['name' => 'Nidera', 'logo' => 'assets/images/marcas/nidera.png'],
            ['name' => 'MacDon', 'logo' => 'assets/images/marcas/macdon.png'],
            ['name' => 'Tatu Marchesan', 'logo' => 'assets/images/marcas/tatumarchesan.png'],
            ['name' => 'Vence Tudo', 'logo' => 'assets/images/marcas/vencetudo.png'],
            ['name' => 'Grap', 'logo' => 'assets/images/marcas/grap.png'],
            ['name' => 'Timken Belts', 'logo' => 'assets/images/marcas/timkenbelts.png'],
            ['name' => 'Orion', 'logo' => 'assets/images/marcas/orion.png'],
            ['name' => 'Akcela', 'logo' => 'assets/images/marcas/akcela.png'],
            ['name' => 'Agro Santa Rosa', 'logo' => 'assets/images/marcas/agrosantarosa.png'],
            ['name' => 'Jassy', 'logo' => 'assets/images/marcas/jassy.png'],
            ['name' => 'TMF', 'logo' => 'assets/images/marcas/tmf.png'],
            ['name' => 'Raven', 'logo' => 'assets/images/marcas/raven.png'],
            ['name' => 'Albuz', 'logo' => 'assets/images/marcas/albuz.png'],
            ['name' => 'Trimble', 'logo' => 'assets/images/marcas/trimble.png'],
            ['name' => 'Difere', 'logo' => 'assets/images/marcas/difere.png'],
            ['name' => 'Penha', 'logo' => 'assets/images/marcas/penha.png'],
            ['name' => 'Inroda', 'logo' => 'assets/images/marcas/inroda.png'],
            ['name' => 'Saframax', 'logo' => 'assets/images/marcas/saframax.png'],
            ['name' => 'Bandeirante', 'logo' => 'assets/images/marcas/bandeirante.png'],
            ['name' => 'Grammer', 'logo' => 'assets/images/marcas/grammer.png'],
            ['name' => 'CNH', 'logo' => 'assets/images/marcas/cnh.png'],
            ['name' => 'Evora', 'logo' => 'assets/images/marcas/evora.png'],
            ['name' => 'Fleet Pro', 'logo' => 'assets/images/marcas/fleetpro.png'],
            ['name' => 'King Implementos', 'logo' => 'assets/images/marcas/kingimplementos.png'],
            ['name' => 'Coopavel', 'logo' => 'assets/images/marcas/coopavel.png'],
            ['name' => 'Arag', 'logo' => 'assets/images/marcas/arag.png'],
            ['name' => 'AgXtend', 'logo' => 'assets/images/marcas/agxtend.png'],
            ['name' => 'Cropfos', 'logo' => 'assets/images/marcas/cropfos.png'],
            ['name' => 'KS', 'logo' => 'assets/images/marcas/ks.png'],
            ['name' => 'Jan', 'logo' => 'assets/images/marcas/jan.png'],
            ['name' => 'Envu', 'logo' => 'assets/images/marcas/envu.png'],
            ['name' => 'Agross', 'logo' => 'assets/images/marcas/agross.png'],
        ];
    }
}
