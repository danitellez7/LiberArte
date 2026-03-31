<?php

namespace Database\Seeders;

use App\Models\Usuario;
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
        // User::factory(10)->create();

        Usuario::factory()->create([
            'nombre' => 'admin',
            'apellidos' => 'principal',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'rol' => 'admin'
        ]);

         Usuario::factory()->create([
            'nombre' => 'tutor',
            'apellidos' => 'cliente',
            'email' => 'tutor@example.com',
            'password' => bcrypt('password'),
            'rol' => 'tutor'
        ]);

         Usuario::factory()->create([
            'nombre' => 'empleado',
            'apellidos' => 'docente',
            'email' => 'empleado@example.com',
            'password' => bcrypt('password'),
            'rol' => 'empleado'
        ]);
    }
}
