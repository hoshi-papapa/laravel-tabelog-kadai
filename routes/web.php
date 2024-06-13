<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

route::get('/hello', function () {
    return view('test');
});

//ユーザーの登録機能
Route::get('/register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('/register', 'Auth\RegisterController@register');

// 'auth.php'ファイルの内容を現在のルート定義ファイルに取り込むためのコード
require __DIR__ . '/auth.php';

// メール認証済みかつログイン中のユーザーのみが使用できるルート
Route::middleware(['auth', 'verified'])->group(function () {

    //ログイン後のページ
    Route::get('/', [StoreController::class, 'index'])->name('store.index');

    //会員情報関連ルート
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });

    Route::resource('stores', StoreController::class)->only(['index', 'show']);

    Route::controller(UserController::class)->group(function () {
        Route::get('users/mypage', 'mypage')->name('mypage');
        Route::get('users/mypage/edit', 'edit')->name('mypage.edit');
        Route::put('users/mypage', 'update')->name('mypage.update');
        Route::get('users/mypage/password/edit', 'edit_password')->name('mypage.edit_password');
        Route::put('users/mypage/password', 'update_password')->name('mypage.update_password');
        Route::delete('users/mypage/delete', 'destroy')->name('mypage.destroy');
    });

    Route::get('/subscription/information', [StripeController::class, 'information'])->name('subscription.information');

    Route::get('/subscription', [StripeController::class, 'subscription'])->name('stripe.subscription');
    Route::post('/subscription/afterpay', [StripeController::class, 'afterpay'])->name('stripe.afterpay');

    //有料会員が使用できるルート
    Route::middleware(['StripeMiddleware'])->group(function () {
        //有料会員機能
        Route::post('reviews', [ReviewController::class, 'store'])->name('reviews.store');

        Route::controller(FavoriteController::class)->group(function () {
            Route::get('favorite/index', 'index')->name('favorite.index');
            Route::post('favorite', 'store')->name('favorite.store');
            Route::delete('favorite/{store}', 'destroy')->name('favorite.destroy');
        });

        Route::controller(ReservationController::class)->group(function () {
            Route::get('reservation/index', 'index')->name('reservation.index');
            Route::get('reservation/{id}', 'show')->name('reservation.show');
            Route::get('reservation/create/{store_id}', 'create')->name('reservation.create');
            Route::post('reservation', 'store')->name('reservation.store');
        });

        //キャンセルフォームを表示するルート
        Route::get('/subscription/cancel', function () {
            return view('post.subscription_cancel', [
                'user' => auth()->user()
            ]);
        })->name('subscription.cancel_form');

        //サブスクリプションをキャンセルするルート
        Route::post('/subscription/cancel/{user}', [StripeController::class, 'cancelsubscription'])->name('stripe.cancel');

        //キャンセル取り消しフォームを表示するルート
        Route::get('/subscription/resume', function () {
            return view('post.subscription_resume', [
                'user' => auth()->user()
            ]);
        })->name('subscription.resume_form');

        //サブスクリプションを再開するルート
        Route::post('/subscription/resume/{user}', [StripeController::class, 'resumesubscription'])->name('stripe.resume');
    });
});

Route::post('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
