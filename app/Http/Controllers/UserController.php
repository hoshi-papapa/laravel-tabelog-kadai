<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function mypage()
    {
        $user = Auth::user();

        //ユーザーのサブスクリプション情報を取得
        $subscriptions = $user->subscriptions;
        $latestSubscription = $subscriptions->first();

        // $latestSubscriptionがnullの場合、ビューに渡す前に処理を行う
        if (!$latestSubscription) {
            // 必要に応じて、nullの場合の処理を追加
            $latestSubscription = null;
        }

        return view('users.mypage', compact('user', 'latestSubscription'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $user = Auth::user();

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user = Auth::user();

        // バリデーションルールを定義
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nickname' => ['nullable', 'string', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:15'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id], // 他のユーザーのメールアドレスと重複しない
            'occupation' => ['nullable', 'string', 'max:255'],
            'age' => ['nullable', 'integer', 'min:0', 'max:150'],
        ]);

        // バリデーションが通ったら、ユーザー情報を更新
        $user->name = $request->input('name');
        $user->nickname = $request->input('nickname');
        $user->phone_number = $request->input('phone_number');
        $user->email = $request->input('email');
        $user->occupation = $request->input('occupation');
        $user->age = $request->input('age');

        $user->save();

        return to_route('mypage');
    }

    public function update_password(Request $request)
    {
        $validatedData = $request->validate([
            'password' => 'required|confirmed',
        ]);

        $user = Auth::user();

        if ($request->input('password') == $request->input('password_confirmation')) {
            $user->password = bcrypt($request->input('password'));
            $user->update();
        } else {
            return to_route('mypage.edit_password');
        }

        return to_route('mypage');
    }

    public function edit_password()
    {
        return view('users.edit_password');
    }

    public function favorite()
    {
        $user = Auth::user();

        $favorite_stores = $user->favorite_stores;

        return view('users.favorite', compact('favorite_stores'));
    }

    public function destroy(Request $request)
    {
        Auth::user()->delete();
        return redirect('/');
    }
}
