<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'nickname' => ['nullable', 'string', 'max:255'], // ニックネーム
            'phone_number' => ['nullable', 'string', 'max:15'], // 電話番号
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'occupation' => ['nullable', 'string', 'max:255'], // 職業
            'age' => ['nullable', 'integer', 'min:0', 'max:150'], // 年齢
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'nickname' => $data['nickname'],
            'phone_number' => $data['phone_number'],
            'email' => $data['email'],
            'occupation' => $data['occupation'],
            'age' => $data['age'],
            // 'subscription_end_date' => null, // サブスク終了日
            // 'subscription_flag' => false, // サブスクフラグ
            'password' => Hash::make($data['password']),
        ]);
    }
}