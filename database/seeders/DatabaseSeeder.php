<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Ejecutar los seeders de catálogos y datos primero
        // para asegurar que todas las tablas base estén creadas.
        $this->call([
            seeder_catalogos::class,
            carga::class,
        ]);
        // User::factory(10)->create();
        $adminRole = Role::firstOrCreate([
            'name' => 'administrador',
            'guard_name' => 'sanctum',
        ]);
        $user = User::factory()->create([
            'name' => 'Super_User',
            'email' => 'test@example.com',
            'password' => Hash::make('admin123')
        ]);
        $user->assignRole('administrador');
    }
}
