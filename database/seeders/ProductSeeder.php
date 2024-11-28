<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $products = [
            [
                'name'  => 'Novel',
                'slug'  => 'novel',
                'price' => 18.99
            ],
            [
                'name'  => 'Laptop',
                'slug'  => 'laptop',
                'price' => 899.99
            ],
            [
                'name'  => 'T-Shirt',
                'slug'  => 't-shirt',
                'price' => 10.99
            ],
        ];

        foreach($products as $productData)
        {
            $product = Product::create($productData);
            $product->categories()->attach(rand(1,3));
        }
    }
}
