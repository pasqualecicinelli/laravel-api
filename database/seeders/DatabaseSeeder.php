<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        /*
        Funziona che mi permette di eliminare, creare e lanciare più seeder 
        contemporaneamente comando php artisan migrate:refresh --seed
        */

        $this->call([

            TechnologySeeder::class,
            TypeSeeder::class,
            ProjectSeeder::class,
            ProjectTechnologySeeder::class,
            UserSeeder::class,


        ]);
    }
}