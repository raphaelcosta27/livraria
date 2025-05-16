<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\AutorSeeder;
use Database\Seeders\AssuntoSeeder;
use Database\Seeders\LivrosSeeder;
use App\Models\User; // Certifique-se que o model User está neste namespace
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AutorSeeder::class,
            AssuntoSeeder::class,
            LivrosSeeder::class
        ]);

        // Criação do usuário Raphael Costa
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@admin.com.br',
            'password' => Hash::make('teste@123'),
            'email_verified_at' => now(), // Marca o e-mail como verificado
        ]);
    }
}
