<?php

namespace Database\Seeders;

// use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\AutorSeeder;
use Database\Seeders\AssuntoSeeder;
use Database\Seeders\LivrosSeeder;

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
        
        // User::factory(10)->create();
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
