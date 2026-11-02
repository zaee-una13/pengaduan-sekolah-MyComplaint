<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['Fasilitas', 'Kedisiplinan'];

        foreach ($categories as $name) {
            Category::firstOrCreate(['name' => $name]);
        }

        
        Category::whereNotIn('name', $categories)
            ->whereDoesntHave('pengaduans')
            ->delete();
    }
}