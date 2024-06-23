@extends('layouts.app')

@section('content')

<div class="container">
  <h3>予約履歴一覧</h3>

  <hr>

  <div class="container mt-4">
    @if($reservations->isEmpty())
      <p>予約履歴はありません。</p>
    @else
      @foreach ($reservations as $reservation)
        <div class="card mb-3">
          <div class="row g-0">
            <div class="col-md-4">
              <a href="{{ route('stores.show', $reservation->store->id) }}" style="text-decoration: none;">
                @if ($reservation->store->image !== "")
                    <img src="{{ asset($reservation->store->image) }}" class="img-thumbnail">
                @else
                    <img src="{{ asset('img/dummy.png') }}" class="img-thumbnail">
                @endif
              </a>
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h5 class="card-title">{{ $reservation->store->name }}</h5>
                <p class="card-text mt-5">{{ $reservation->store->description }}</p>
                <p class="card-text">来店日：{{ \Carbon\Carbon::parse($reservation->reservation_date)->format('Y年n月j日 G時i分') }}</p>
                <p class="card-text">ご予約人数：{{ $reservation->number_of_people }}名</p>
                <div class="d-flex justify-content-start">
                  <a href="{{ route('reservation.show', $reservation->id) }}" class="btn btn-outline-primary me-2">
                      予約の詳細を確認する
                  </a>
                  @php
                    $now = \Carbon\Carbon::now();
                    $reservationDate = \Carbon\Carbon::parse($reservation->reservation_date);
                  @endphp
                  @if ($reservationDate->gte($now))
                    <form action="{{ route('reservation.destroy', $reservation->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger">予約をキャンセルする</button>
                    </form>
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    @endif
  </div>
</div>

@endsection