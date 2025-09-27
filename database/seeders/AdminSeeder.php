<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Administrador;
use App\Models\User;
use App\Models\Airpods;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear administrador por defecto
        Administrador::create([
            'name' => 'Administrador Principal',
            'email' => 'admin@techstore.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Crear usuario cliente de prueba
        User::create([
            'name' => 'Cliente de Prueba',
            'email' => 'cliente@test.com',
            'password' => Hash::make('cliente123'),
            'phone' => '+1234567890',
            'role' => 'cliente',
            'is_active' => true,
        ]);

        // Crear algunos productos AirPods de prueba
        Airpods::create([
            'name' => 'AirPods Pro (2ª generación)',
            'description' => 'Los AirPods Pro más avanzados con cancelación activa de ruido y audio espacial personalizado.',
            'price' => 249.99,
            'category' => 'Premium',
            'stock' => 50,
            'features' => json_encode([
                'Cancelación activa de ruido',
                'Audio espacial personalizado',
                'Resistente al agua IPX4',
                'Hasta 6 horas de reproducción'
            ]),
            'is_active' => true,
        ]);

        Airpods::create([
            'name' => 'AirPods (3ª generación)',
            'description' => 'AirPods con audio espacial y hasta 6 horas de reproducción.',
            'price' => 179.99,
            'category' => 'Estándar',
            'stock' => 75,
            'features' => json_encode([
                'Audio espacial',
                'Resistente al agua IPX4',
                'Hasta 6 horas de reproducción',
                'Estuche de carga MagSafe'
            ]),
            'is_active' => true,
        ]);

        Airpods::create([
            'name' => 'AirPods Max',
            'description' => 'Auriculares circumaurales con cancelación activa de ruido y audio de alta fidelidad.',
            'price' => 549.99,
            'category' => 'Premium',
            'stock' => 25,
            'features' => json_encode([
                'Cancelación activa de ruido',
                'Audio de alta fidelidad',
                'Hasta 20 horas de reproducción',
                'Diadema de malla transpirable'
            ]),
            'is_active' => true,
        ]);
    }
}
