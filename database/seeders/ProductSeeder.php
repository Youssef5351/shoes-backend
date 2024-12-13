<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{

    public function run(): void
    {
        Product::create([
            'name' => 'CeraVe PM Facial Moisturizing Lotion 52ml',
            'description' => 'Description for product 1',
            'price' => 319,
            'image_url' => 'images/cerave.webp',
            'hoverImage'=> 'images/cerave-hover.webp',
            'stock_quantity' => 10,
            'category_id' => 1, 
            'brand' => 'CeraVe',
            'fragrance_family' => 'Floral',
            "is_featured" => false
        ]);

        Product::create([
            'name' => 'Guess By Marciano Eau De Parfum Spray For Women 100ml',
            'description' => 'Description for product 2',
            'price' => 1390,
            'image_url' => 'images/marciano.webp',
            'hoverImage'=> 'images/marciano-hover.webp',
            'stock_quantity' => 10,
            'category_id' => 2, 
            'brand' => 'Guess',
            'fragrance_family' => 'Perfume',
            "is_featured" => false
        ]); 

        Product::create([
            'name' => 'Guess Gold Eau De Parfum Spray For Women 75ml',
            'description' => 'Description for product 2',
            'price' => 1650,
            'image_url' => 'images/gold.webp',
            'hoverImage'=> 'images/gold-hover.webp',
            'stock_quantity' => 10,
            'category_id' => 2, 
            'brand' => 'Guess',
            'fragrance_family' => 'Perfume',
            "is_featured" => false
        ]); 
        Product::create([
            'name' => 'Guess Seductive Noir Homme Eau De Toilette Spray 100ml For Him',
            'description' => 'Description for product 2',
            'price' => 1749,
            'image_url' => 'images/noir.webp',
            'hoverImage'=> 'images/noir-hover.webp',
            'stock_quantity' => 10,
            'category_id' => 2, 
            'brand' => 'Guess',
            'fragrance_family' => 'Perfume',
            "is_featured" => false
        ]); 
        Product::create([
            'name' => 'Giorgio Armani Stronger With You Absolutely Eau de Parfum For Men',
            'description' => 'Description for product 2',
            'price' => 5950,
            'image_url' => 'images/gio.webp',
            'hoverImage'=> 'images/gio-hover.webp',
            'stock_quantity' => 10,
            'category_id' => 2, 
            'brand' => 'Giorgio',
            'fragrance_family' => 'Perfume',
            "is_featured" => false
        ]); 
        Product::create([
            'name' => 'Guess Seductive Eau De Toilette Spray For Women',
            'description' => 'Description for product 2',
            'price' => 2290,
            'image_url' => 'images/newguess.webp',
            'hoverImage'=> 'images/newguess-hover.webp',
            'stock_quantity' => 10,
            'category_id' => 2, 
            'brand' => 'Guess',
            'fragrance_family' => 'Perfume',
            "is_featured" => true
        ]); 
        Product::create([
            'name' => 'Calvin Klein Euphoria Eau De Parfum For Women 100ml',
            'description' => 'Description for product 2',
            'price' => 4290,
            'image_url' => 'images/calvin.webp',
            'hoverImage'=> 'images/calvin-hover.webp',
            'stock_quantity' => 10,
            'category_id' => 2, 
            'brand' => 'Calvin Klien',
            'fragrance_family' => 'Perfume',
            "is_featured" => true
        ]); 
        Product::create([
            'name' => 'Dior Sauvage Eau De Parfum For Men',
            'description' => 'Description for product 2',
            'price' => 8290,
            'image_url' => 'images/Dior.webp',
            'hoverImage'=> 'images/dior-hover.webp',
            'stock_quantity' => 10,
            'category_id' => 2, 
            'brand' => 'Dior',
            'fragrance_family' => 'Perfume',
            'shopify_product_id' => '8240564928711',
            "is_featured" => true
        ]); 
        Product::create([
            'name' => 'Christian Dior Eau Sauvage Eau De Toilette',
            'description' => 'Description for product 2',
            'price' => 7890,
            'image_url' => 'images/sauvage.webp',
            'hoverImage'=> 'images/sauvage.webp',
            'stock_quantity' => 10,
            'category_id' => 2, 
            'brand' => 'Dior',
            'fragrance_family' => 'Perfume',
            "is_featured" => true
        ]); 
        Product::create([
            'name' => 'Dior Oud Ispahan Eau de Parfum',
            'description' => 'Description for product 2',
            'price' => 29890,
            'image_url' => 'images/oud.webp',
            'hoverImage'=> 'images/oud.webp',
            'stock_quantity' => 10,
            'category_id' => 2,
            'brand' => 'Calvin Klien',
            'fragrance_family' => 'Perfume',

            "is_featured" => true
        ]); 
    }
}

