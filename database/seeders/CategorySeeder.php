<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Artes Plásticas',      'icon' => '🎨'],
            ['name' => 'Música',                'icon' => '🎵'],
            ['name' => 'Danza y Teatro',        'icon' => '💃'],
            ['name' => 'Literatura',            'icon' => '📚'],
            ['name' => 'Fotografía y Video',    'icon' => '📷'],
            ['name' => 'Artesanía',             'icon' => '🧶'],
            ['name' => 'Gastronomía Cultural',  'icon' => '🍲'],
            ['name' => 'Tecnología e Innovación','icon'=> '💻'],
            ['name' => 'Patrimonio Cultural',   'icon' => '🏛'],
            ['name' => 'Circo y Acrobacia',     'icon' => '🎪'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(
                ['slug' => Str::slug($cat['name'])],
                ['name' => $cat['name'], 'icon' => $cat['icon']]
            );
        }
    }
}
