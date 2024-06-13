<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Store;

class StoreCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //ランダムな関連付けを追加するロジックを実装
        $stores = Store::all();
        $categories = Category::all();

        foreach ($stores as $store) {
            //ランダムなカテゴリを選択して関連付ける
            $randomCategories = $categories->random(rand(1, 3)); //1から3つのランダムなカテゴリを選択
            $store->categories()->attach($randomCategories->pluck('id')->toArray());
        }
    }
}