@extends('layouts.app')

@section('content')

<div class="container">
    <h3>プレミアムプランを解約する</h3>
    <hr>

		<div class="card">
				<div class="card-body">
						<p class="card-text">プレミアムプランを解約される場合は、下のボタンをクリックしてください<br>
							ご解約された場合でも、次回のお支払日までは有料プランを利用可能です</p>
						<form method="POST" action="{{route('stripe.cancel', ['user' => $user->id]) }}">
							@csrf
							<button class="btn btn-danger">解約する</button>
						</form>
				</div>
		</div>
</div>

@endsection