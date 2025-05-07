<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categories;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Categories::create([
            'name' => 'Museo',
        ]);

        Categories::create([
            'name' => 'Parque',
        ]);

        Categories::create([
            'name' => 'Castillo',
        ]);

        Categories::create([
            'name' => 'Iglesia',
        ]);

        Categories::create([
            'name' => 'Biblioteca',
        ]);

        Categories::create([
            'name' => 'Monumento',
        ]);

        Categories::create([
            'name' => 'Otros',
        ]);

        Categories::create([
            'name' => 'Plaza',
        ]);
    }
}