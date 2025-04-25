<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Romance',
                'description' => 'Cerita dengan tema percintaan dan romansa',
            ],
            [
                'name' => 'Horror',
                'description' => 'Cerita dengan tema seram dan menakutkan',
            ],
            [
                'name' => 'Comedy',
                'description' => 'Cerita dengan unsur humor dan komedi',
            ],
            [
                'name' => 'Drama',
                'description' => 'Cerita dengan konflik kehidupan sehari-hari',
            ],
            [
                'name' => 'Fantasi',
                'description' => 'Cerita dengan elemen fantasi dan imajinasi',
            ],
            [
                'name' => 'Inspiratif',
                'description' => 'Cerita yang memberikan inspirasi dan motivasi',
            ],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
            ]);
        }
    }
}
