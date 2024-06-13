<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Store;
use App\Models\Favorite;

class FavoriteController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $favorites = Favorite::where('user_id', $user->id)->with('store')->get();

        return view('favorite.index', compact('favorites'));
    }

    //
    public function store(Request $request)
    {
        $user = Auth::user();
        $store = Store::findOrfail($request->input('store_id'));

        if (!Favorite::where('user_id', $user->id)->where('store_id', $store->id)->exists()) {
            Favorite::create([
                'user_id' => $user->id,
                'store_id' => $store->id,
            ]);
        }

        return redirect()->back()->with('success', '店舗をお気に入り登録しました。');
    }

    public function destroy(Store $store)
    {
        $user = Auth::user();

        Favorite::where('user_id', $user->id)->where('store_id', $store->id)->delete();

        return redirect()->back()->with('success', '店舗をお気に入りから削除しました。');
    }
}
