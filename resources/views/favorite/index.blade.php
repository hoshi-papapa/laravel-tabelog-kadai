@extends('layouts.app')

@section('content')

<div class="container">
  <h3>お気に入り一覧</h3>

  <hr>

  <div class="container mt-4">
    @if($favorites->isEmpty())
      <p>お気に入り登録店舗がありません。</p>
    @else
      @foreach ($favorites as $favorite)
        <div class="card mb-3">
          <div class="row g-0">
            <div class="col-md-4">

              <a href="{{ route('stores.show', $favorite->store->id) }}" style="text-decoration: none;">
                @if ($favorite->store->image !== "")
                    <img src="{{ asset($favorite->store->image) }}" class="img-thumbnail">
                @else
                    <img src="{{ asset('img/dummy.png') }}" class="img-thumbnail">
                @endif
              </a>
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h5 class="card-title">{{ $favorite->store->name }}</h5>
                @if ($favorite->store->average_review)
                    <div style="display: flex; align-items: center;" class="mb-2">
                        <div class="star-rating" data-rate={{ round($favorite->store->average_review * 2) /2 }}></div>
                        <div class="rating">　{{ number_format(round($favorite->store->average_review, 1), 1) }}</div>
                    </div>
                @else
                    <div style="display: flex; align-items: center;" class="mb-2">
                        <div class="star-rating" data-rate={{ round($favorite->store->average_review * 2) /2 }}></div>
                        <div class="rating">　－</div>
                    </div>
                @endif
                <p class="card-text">{{ $favorite->store->description }}</p>

                <div>
                    <a href="{{ route('favorite.destroy', $favorite->store->id) }}" class="btn btn-danger" 
                        onclick="event.preventDefault(); document.getElementById('favorites-destroy-form{{$favorite->store->id}}').submit();">
                        お気に入りから削除
                    </a>
                    <form id="favorites-destroy-form{{$favorite->store->id}}" action="{{ route('favorite.destroy', $favorite->store->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                    </form>
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