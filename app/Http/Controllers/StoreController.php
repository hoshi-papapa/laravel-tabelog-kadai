<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StoreController extends Controller
{

    // すべてのカテゴリを取得する関数
    public function getAllCategories()
    {
        return Category::all();
    }

    public function index(Request $request)
    {
        //検索ボックスの値を取得
        $keyword = $request->keyword;
        $category_id = $request->category;

        // 並び替えのキーと値を設定
        $sorts = [
            'updated_at desc' => '新着順',
            'reviews_avg_rating desc' => 'レビューの高い順',
        ];

        // 並び替えセレクトボックスの値を設定（初期値）
        $defaultSort = "updated_at desc";
        $sorted = $defaultSort;

        // 並び替えの指定がある場合
        if ($request->has('select_sort')) {
            $sorted = $request->input('select_sort');
        }

        // $sortableと$directionを取得
        [$sortable, $direction] = explode(' ', $sorted);

        // ベースクエリを定義
        $query = Store::withAvg('reviews', 'rating')->with('categories');

        // カテゴリに基づくフィルタリング
        if ($category_id) {
            $query->whereHas('categories', function ($query) use ($category_id) {
                $query->where('category_id', $category_id);
            });
            $selected_category = Category::find($category_id);
        } else {
            $selected_category = null;
        }

        // キーワードに基づくフィルタリング
        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                    ->orWhereHas('categories', function ($q) use ($keyword) {
                        $q->where('name', 'like', "%{$keyword}%");
                    });
            });
        }

        // 並び替え
        if ($sortable === 'reviews_avg_rating') {
            $query->orderBy('reviews_avg_rating', $direction);
        } else {
            $query->orderBy($sortable, $direction);
        }

        $stores = $query->paginate(10);
        $total_count = $query->count();
        $categories = Category::inRandomOrder()->limit(10)->get();

        // 全カテゴリを取得
        $allcategories = $this->getAllCategories();

        return view('stores.index', compact('sorts', 'sorted', 'stores', 'categories', 'allcategories',  'total_count', 'selected_category', 'keyword'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function show(Store $store)
    {

        $reviews = $store->reviews()->get();

        // 店舗の中間テーブルに紐づいているカテゴリーのリストを取得する
        $store = Store::find($store->id);
        $categories = $store->categories;

        return view('stores.show', compact('store', 'reviews', 'categories'));
    }
}
