<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            '和食',
            '洋食',
            '中華',
            'イタリアン',
            'フレンチ',
            'インド料理',
            '韓国料理',
            'タイ料理',
            'ベトナム料理',
            'メキシコ料理',
            'アメリカ料理',
            'スペイン料理',
            'ギリシャ料理',
            'トルコ料理',
            'ブラジル料理',
            'モロッコ料理',
            'エチオピア料理',
            'ハワイ料理',
            'カフェ',
            'ビュッフェ',
            'ファーストフード',
            'バーベキュー',
            'シーフード',
            'ステーキハウス',
            'ピザ',
            'ベジタリアン',
            'ヴィーガン',
            'デザート',
            'スイーツ',
            'タピオカ',
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}