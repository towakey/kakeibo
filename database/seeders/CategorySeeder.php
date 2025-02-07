<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            '交通費',
            '交際費',
            '住居費',
            '医療費',
            '教育費',
            '日用品費',
            '水道光熱費',
            '被服費',
            '娯楽費',
            '通信費',
            '食費',
            'その他'
        ];

        // 全ユーザーに対してカテゴリを作成
        User::all()->each(function ($user) use ($categories) {
            foreach ($categories as $category) {
                Category::create([
                    'user_id' => $user->id,
                    'name' => $category,
                    'description' => $category . 'に関する支出'
                ]);
            }
        });
    }
}
