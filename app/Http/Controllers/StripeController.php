<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;
use Stripe\Stripe;
use Stripe\Charge;
use App\Models\User;
use Stripe\Customer;
use Illuminate\Support\Facades\Log;
use function Illuminate\Events\queueable;

class StripeController extends Controller
{
    public function subscription(Request $request)
    {
        $user = Auth::user();
        return view('post.subscription',  [
            'intent' => $user->createSetupIntent()
        ]);
    }

    public function afterpay(Request $request)
    {
        $user = Auth::user();

        $stripeCustomer = $user->createOrGetStripeCustomer();

        // フォーム送信の情報から$paymentMethodを作成する
        $paymentMethod = $request->input('stripePaymentMethod');

        // プランはconfigに設定したbasic_plan_idとする
        $plan = config('services.stripe.basic_plan_id');

        // 上記のプランと支払方法で、サブスクを新規作成する
        $user->newSubscription('default', $plan)
            ->create($paymentMethod);

        // 処理後に'ルート設定'にページ移行
        return redirect()->route('mypage');
    }

    public function cancelsubscription(User $user, Request $request)
    {
        $user->subscription('default')->cancel();
        // 処理後に'ルート設定'にページ移行
        return redirect()->route('mypage');
    }

    public function resumesubscription(User $user, Request $request)
    {
        $user->subscription('default')->resume();
        // 処理後に'ルート設定'にページ移行
        return redirect()->route('mypage');
    }

    public function information()
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

        return view('subscription_information', compact('latestSubscription'));
    }
}
