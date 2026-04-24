<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Technology',
            'Business',
            'Education',
            'Design',
            'Health',
            'Marketing',
        ];

        foreach ($categories as $categoryName) {
            Category::firstOrCreate([
                'name' => $categoryName,
            ]);
        }
    }
}