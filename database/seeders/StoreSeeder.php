<?php

namespace Database\Seeders;

use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        
        $stores = [
            ['name' => 'スーパーマーケット', 'description' => '食料品や日用品の購入'],
            ['name' => 'コンビニエンスストア', 'description' => '日用品の購入'],
            ['name' => 'ドラッグストア', 'description' => '医薬品や化粧品の購入'],
        ];

        foreach ($stores as $store) {
            Store::create([
                'user_id' => $user->id,
                'name' => $store['name'],
                'description' => $store['description'],
            ]);
        }
    }
}
