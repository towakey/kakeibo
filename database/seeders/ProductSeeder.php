<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        
        $products = [
            [
                'name' => '牛乳',
                'description' => '1リットル',
                'default_price' => 230,
                'default_tax_type' => 8,
            ],
            [
                'name' => 'パン',
                'description' => '6枚切り',
                'default_price' => 150,
                'default_tax_type' => 8,
            ],
            [
                'name' => 'バナナ',
                'description' => '1房',
                'default_price' => 198,
                'default_tax_type' => 8,
            ],
        ];

        foreach ($products as $product) {
            Product::create([
                'user_id' => $user->id,
                'name' => $product['name'],
                'description' => $product['description'],
                'default_price' => $product['default_price'],
                'default_tax_type' => $product['default_tax_type'],
            ]);
        }
    }
}
