<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $noticias = BlogCategory::firstOrCreate(['slug' => 'noticias'], ['name' => 'Noticias']);
        $eventos = BlogCategory::firstOrCreate(['slug' => 'eventos'], ['name' => 'Eventos']);
        $tips = BlogCategory::firstOrCreate(['slug' => 'tips-agricolas'], ['name' => 'Tips Agrícolas']);

        $admin = User::first();

        if (BlogPost::count() === 0) {
            BlogPost::create([
                'title' => 'Ciabay presente en Expo Pioneros 2025',
                'slug' => 'ciabay-presente-expo-pioneros-2025',
                'excerpt' => 'Participamos de la Expo Pioneros 2025 con las últimas novedades en maquinaria Case IH.',
                'content' => '<p>Ciabay participó de la Expo Pioneros 2025, uno de los eventos agrícolas más importantes del Chaco paraguayo. En nuestro stand, los visitantes pudieron conocer las últimas novedades en maquinaria agrícola Case IH.</p><p>Presentamos los nuevos modelos de tractores y cosechadoras, así como soluciones de agricultura de precisión para optimizar la producción.</p>',
                'blog_category_id' => $noticias->id,
                'author_id' => $admin->id,
                'status' => 'published',
                'published_at' => now()->subDays(5),
            ]);

            BlogPost::create([
                'title' => 'Jornada de Campo: Tecnología de Precisión',
                'slug' => 'jornada-campo-tecnologia-precision',
                'excerpt' => 'Realizamos una jornada de campo para demostrar las ventajas de la agricultura de precisión.',
                'content' => '<p>En nuestra sucursal de Santa Rita, realizamos una jornada de campo donde productores de la zona pudieron ver en acción las tecnologías de agricultura de precisión que ofrecemos.</p><p>Los asistentes pudieron probar pilotos automáticos, monitores de siembra y cosecha, y sistemas de telemetría.</p>',
                'blog_category_id' => $eventos->id,
                'author_id' => $admin->id,
                'status' => 'published',
                'published_at' => now()->subDays(12),
            ]);

            BlogPost::create([
                'title' => '5 consejos para el mantenimiento de tu tractor',
                'slug' => '5-consejos-mantenimiento-tractor',
                'excerpt' => 'Mantené tu tractor en óptimas condiciones con estos consejos de nuestros técnicos.',
                'content' => '<p>El mantenimiento preventivo es fundamental para asegurar la vida útil de tu maquinaria. Nuestros técnicos comparten 5 consejos clave:</p><ol><li><strong>Revisá el aceite regularmente:</strong> Cambiá el aceite según las horas de uso recomendadas por el fabricante.</li><li><strong>Chequeá los filtros:</strong> Los filtros de aire, combustible y aceite deben estar siempre en buen estado.</li><li><strong>Inspeccioná los neumáticos:</strong> La presión correcta mejora la eficiencia y reduce el desgaste.</li><li><strong>Limpiá el radiador:</strong> Un radiador limpio previene el sobrecalentamiento.</li><li><strong>Usá repuestos originales:</strong> Garantizan el mejor rendimiento y compatibilidad.</li></ol>',
                'blog_category_id' => $tips->id,
                'author_id' => $admin->id,
                'status' => 'published',
                'published_at' => now()->subDays(20),
            ]);
        }
    }
}
