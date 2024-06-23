<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
  public function showLoginForm()
  {
    return view('auth.custom-admin-login');
  }

  public function login(Request $request)
  {
    $request->validate([
      'username' => 'required|string',
      'password' => 'required|string',
    ]);

    $credentials = $request->only('username', 'password');

    if (Auth::guard('admin')->attempt($credentials)) {
      // ログイン成功
      return redirect()->intended('admin');
    }

    // ログイン失敗
    return back()->withErrors([
      'username' => 'ユーザー名またはパスワードが間違っています。',
    ]);
  }
}
