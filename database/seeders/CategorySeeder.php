<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Romantis',
                'slug' => 'romantis',
            ],
            [
                'name' => 'Horor',
                'slug' => 'horor',
            ],
            [
                'name' => 'Komedi',
                'slug' => 'komedi',
            ],
            [
                'name' => 'Drama',
                'slug' => 'drama',
            ],
            [
                'name' => 'Fantasi',
                'slug' => 'fantasi',
            ],
            [
                'name' => 'Inspiratif',
                'slug' => 'inspiratif',
            ],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => $category['slug'],
            ]);
        }
    }
}
