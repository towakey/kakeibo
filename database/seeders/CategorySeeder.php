<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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

        try {
            // 既存のカテゴリーを削除
            Category::truncate();
            echo "Truncated categories table\n";

            // 共通カテゴリーを作成（user_idはnull）
            foreach ($categories as $category) {
                $cat = Category::create([
                    'user_id' => null,  // user_idをnullに設定して全ユーザーで共有
                    'name' => $category,
                    'description' => $category . 'に関する支出'
                ]);
                echo "Created category: " . $category . " with ID: " . $cat->id . "\n";
            }

            // 作成されたカテゴリー数を確認
            $categoryCount = Category::count();
            echo "Total categories created: " . $categoryCount . "\n";

        } catch (\Exception $e) {
            echo "Error occurred: " . $e->getMessage() . "\n";
            echo "File: " . $e->getFile() . "\n";
            echo "Line: " . $e->getLine() . "\n";
        }
    }
}
