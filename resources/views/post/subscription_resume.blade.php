@extends('layouts.app')

@section('content')

<div class="container">
    <h3>プレミアムプランの継続</h3>
    <hr>

		<div class="card">
				<div class="card-body">
						<p class="card-text">プレミアムプランをご継続される場合は、下のボタンをクリックしてください</p>
						<form method="POST" action="{{route('stripe.resume', ['user' => $user->id]) }}">
							@csrf
							<button class="btn btn-warning">継続する</button>
						</form>
				</div>
		</div>
</div>

@endsection