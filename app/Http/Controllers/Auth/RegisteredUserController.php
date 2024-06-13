<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nickname' => ['nullable', 'string', 'max:255'], // ニックネーム
            'phone_number' => ['nullable', 'string', 'max:15'], // 電話番号
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'occupation' => ['nullable', 'string', 'max:255'], // 職業
            'age' => ['nullable', 'integer', 'min:0', 'max:150'], // 年齢
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'nickname' => $request->nickname, // ニックネーム
            'phone_number' => $request->phone_number, // 電話番号
            'email' => $request->email,
            'occupation' => $request->occupation, // 職業
            'age' => $request->age, // 年齢
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect('/verify-email');
    }
}
