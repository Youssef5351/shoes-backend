<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create categories
        Category::create(['name' => 'Category 1']);
        Category::create(['name' => 'Category 2']);
        // Add more categories as needed
    }
}
