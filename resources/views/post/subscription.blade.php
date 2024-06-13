@extends('layouts.app')

@section('content')

<div class="container">
    <h3>プレミアムプラン登録</h3>
    <hr>

    <div class="emphasize">プレミアム会員になると、月額500円（税込）で下記の機能をお使いいただけます。</div>
		<br>
    <div class="text-muted">
      　お気に入り登録・解除
    </div>
    <div class="text-muted">
      　店舗予約
    </div>
    <div class="text-muted">
      　レビュー投稿
    </div>
		<br>

		<div class="card">
				<div class="card-body">
						<form action="{{route('stripe.afterpay')}}" method="post" id="payment-form">
							@csrf
							
								<label for="exampleInputEmail1">お名前</label>
								<input type="test" class="form-control col-sm-5" id="card-holder-name" required>
						
								<label for="exampleInputPassword1">カード番号</label>
								<div class="form-group MyCardElement col-sm-5" id="card-element" style="border: 1px solid #ccc; padding: 10px;"></div>
						
								<div id="card-errors" role="alert" style='color:red'></div>
						
								<button class="btn btn-warning mt-3" id="card-button" data-secret="{{ $intent->client_secret }}">登録する</button>
						
						</form>
				</div>
		</div>
</div>

<script>
 
	// HTMLの読み込み完了後に実行するようにする
	window.onload = my_init;
	function my_init() {
 
		// Configに設定したStripeのAPIキーを読み込む  
		const stripe = Stripe("{{ config('services.stripe.pb_key') }}");
		const elements = stripe.elements();
 
		var style = {
			base: {
			color: "#32325d",
			fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
			fontSmoothing: "antialiased",
			fontSize: "16px",
			"::placeholder": {
			color: "#aab7c4"
			}
		},
		invalid: {
			color: "#fa755a",
			iconColor: "#fa755a"
		}
		};
		
		const cardElement = elements.create('card', {style: style, hidePostalCode: true});
		cardElement.mount('#card-element');
 
		const cardHolderName = document.getElementById('card-holder-name');
		const cardButton = document.getElementById('card-button');
		const clientSecret = cardButton.dataset.secret;
 
		cardButton.addEventListener('click', async (e) => {
			// formのsubmitボタンのデフォルト動作を無効にする
			e.preventDefault();
			const { setupIntent, error } = await stripe.confirmCardSetup(
				clientSecret, {
					payment_method: {
					card: cardElement,
					billing_details: { name: cardHolderName.value }
					}
				}
			);
			
			if (error) {
			// エラー処理
			console.log('error');
			
			} else {
			// 問題なければ、stripePaymentHandlerへ
			stripePaymentHandler(setupIntent);
			}
		});
	}
	
	function stripePaymentHandler(setupIntent) {
	var form = document.getElementById('payment-form');
	var hiddenInput = document.createElement('input');
	hiddenInput.setAttribute('type', 'hidden');
	hiddenInput.setAttribute('name', 'stripePaymentMethod');
	hiddenInput.setAttribute('value', setupIntent.payment_method);
	form.appendChild(hiddenInput);
	// フォームを送信
	form.submit();
	}
</script>

@endsection