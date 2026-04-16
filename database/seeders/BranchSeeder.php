<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        $branches = [
            [
                'name' => 'Bella Vista',
                'address' => 'Ruta 06 Km 51',
                'city' => 'Bella Vista',
                'department' => 'Itapúa',
                'phone' => '+595 767 240 200',
                'email' => 'bellavista@ciabay.com.py',
                'image' => 'assets/images/sucursales/BellaVista.png',
                'latitude' => -27.0500,
                'longitude' => -55.5333,
                'sort_order' => 0,
                'is_active' => true,
            ],
            [
                'name' => 'Campo 9',
                'address' => 'Ruta PY 02 Km 207, Calle 6',
                'city' => 'Dr. Juan Manuel Frutos',
                'department' => 'Caaguazú',
                'phone' => '+595 528 222 000',
                'email' => 'campo9@ciabay.com.py',
                'image' => 'assets/images/sucursales/Campo9.png',
                'latitude' => -25.5833,
                'longitude' => -55.9833,
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Casa Matriz',
                'address' => 'Supercarretera Km 2,5',
                'city' => 'Hernandarias',
                'department' => 'Alto Paraná',
                'phone' => '+595 631 22335',
                'email' => 'contacto@ciabay.com',
                'image' => 'assets/images/sucursales/Hernandarias.png',
                'latitude' => -25.4000,
                'longitude' => -54.6333,
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Katueté',
                'address' => 'Super carretera 40, Avda. Las Residentes 1442',
                'city' => 'Katueté',
                'department' => 'Canindeyú',
                'phone' => '+595 46 242 456',
                'email' => 'katuete@ciabay.com.py',
                'image' => 'assets/images/sucursales/Katuete.png',
                'latitude' => -24.1667,
                'longitude' => -54.7500,
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Loma Plata',
                'address' => 'Acceso L P, Reiland',
                'city' => 'Loma Plata',
                'department' => 'Boquerón',
                'phone' => '+595 492 252 300',
                'email' => 'lomaplata@ciabay.com.py',
                'image' => 'assets/images/sucursales/LomaPlata.png',
                'latitude' => -22.3833,
                'longitude' => -59.8333,
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Río Verde',
                'address' => 'Ruta PY 08 Dr. Blas Garay Km 342,5',
                'city' => 'Colonia Río Verde',
                'department' => 'San Pedro',
                'phone' => '+595 343 210 400',
                'email' => 'rioverde@ciabay.com.py',
                'image' => 'assets/images/sucursales/RioVerde.png',
                'latitude' => -23.8667,
                'longitude' => -56.1833,
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'San Alberto',
                'address' => 'Ruta PY 07 Km 92',
                'city' => 'San Alberto',
                'department' => 'Alto Paraná',
                'phone' => '+595 643 220 500',
                'email' => 'sanalberto@ciabay.com.py',
                'image' => 'assets/images/sucursales/SanAlberto.png',
                'latitude' => -25.1833,
                'longitude' => -54.9500,
                'sort_order' => 6,
                'is_active' => true,
            ],
            [
                'name' => 'Santa Rita',
                'address' => 'Ruta PY 06 Km 206',
                'city' => 'Santa Rita',
                'department' => 'Alto Paraná',
                'phone' => '+595 673 220 200',
                'email' => 'santarita@ciabay.com.py',
                'image' => 'assets/images/sucursales/SantaRita.png',
                'latitude' => -25.7833,
                'longitude' => -55.0833,
                'sort_order' => 7,
                'is_active' => true,
            ],
        ];

        foreach ($branches as $data) {
            Branch::updateOrCreate(['name' => $data['name']], $data);
        }
    }
}
