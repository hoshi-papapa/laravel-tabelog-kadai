@extends('layouts.app')

@section('content')

<div class="container">

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h3>{{$store->name}}</h3>

    <hr>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                @if ($store->image)
                    <img src="{{ asset($store->image) }}" class="card-img-top">
                @else
                    <img src="{{ asset('img/dummy.png')}}" class="card-img-top">
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{$store->name}}</h5>
                    <p class="card-text">{{$store->description}}</p>
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                            <th scope="row">カテゴリ</th>
                            <td>
                                @foreach ($categories as $index => $category)
                                    <span>{{ $category->name }}</span>
                                    @if ($index < count($categories) - 1)
                                        <span>, </span>
                                    @endif
                                @endforeach
                            </td>
                            </tr>
                            <tr>
                            <th scope="row">住所</th>
                            <td>{{$store->Address}}</td>
                            </tr>
                            <tr>
                            <th scope="row">電話番号</th>
                            <td>{{$store->phone_number}}</td>
                            </tr>
                            <tr>
                            <th scope="row">営業時間</th>
                            <td>{{$store->business_hours}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="text-center d-grid gap-2 col-8 mx-auto mb-3">
                        <a class="btn btn-warning" href="{{ route('reservation.create', ['store_id' => $store->id])}}">予約する</a>
                    </div>
                    @php
                        $isFavorited = \App\Models\Favorite::where('user_id', Auth::id())->where('store_id', $store->id)->exists();
                    @endphp
                    @if ($isFavorited)
                        <form method="POST" action="{{ route('favorite.destroy', $store) }}" class="text-center d-grid gap-2 col-8 mx-auto">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">お気に入り解除</button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('favorite.store') }}" class="text-center d-grid gap-2 col-8 mx-auto">
                            @csrf
                            <input type="hidden" name="store_id" value="{{ $store->id }}">
                            <button type="submit" class="btn btn-outline-danger">お気に入り登録</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <br>
    <hr>

    <h3>レビューを投稿する</h3>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('reviews.store') }}">
                @csrf
                @error('rating')
                    <strong>評価を入力してください</strong>
                @enderror
                @error('comment')
                    <strong>レビュー内容を入力してください</strong>
                @enderror

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 0px">星をクリックして評価できます</label>
                    <div class="rating rating-form">
                        <input type="hidden" name="rating" id="ratingValue" value="">
                        <button type="button" class="star-btn" data-value="1">★</button>
                        <button type="button" class="star-btn" data-value="2">★</button>
                        <button type="button" class="star-btn" data-value="3">★</button>
                        <button type="button" class="star-btn" data-value="4">★</button>
                        <button type="button" class="star-btn" data-value="5">★</button>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">コメントを入力してください</label>
                    <textarea name="comment" class="form-control" rows="3"></textarea>
                </div>
                <input type="hidden" name="store_id" value="{{ $store->id }}">
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                <button type="submit" class="btn btn-warning" id="submitReview">レビューを投稿</button>
            </form>
        </div>
    </div>

    <br>
    <hr>
    <div class="container">
        <div class="row align-items-center mb-2">
            <div class="col-auto">
                <h3 style="margin-right: 1.5rem;">みんなのレビュー</h3>
            </div>
            <div class="col-auto d-flex align-items-center">
                <label style="margin-right: 0.5rem;">平均評価</label>
                @if ($store->average_review)
                    <div class="star-rating" data-rate={{ round($store->average_review * 2) /2 }} style="margin-right: 0.5rem;"></div>
                    <div class="rating" style="font-size: 1rem;">{{ number_format(round($store->average_review, 1), 1) }}</div>
                @else
                    <div class="star-rating" data-rate={{ round($store->average_review * 2) /2 }} style="margin-right: 0.5rem;"></div>
                    <div class="rating" style="font-size: 1rem;">－</div>
                @endif
            </div>
        </div>
    </div>

    @foreach ($reviews as $review)
        <div class="card mb-3">
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title">{{ $review->user->nickname }}</h5>
                    <div style="display: flex; align-items: center;" class="mb-1">
                        <div class="star-rating" data-rate={{ floatval($review->rating) }}></div>
                        <div class="rating" style="font-size: 1rem;">　{{ number_format(round($review->rating, 1), 1) }}</div>
                    </div>
                    <p class="card-text">{{$review->comment}}</p>
                    <p class="card-text text-muted">投稿日：{{ \Carbon\Carbon::parse($review->created_at)->format('Y年n月j日') }}</p>
                </div>
            </div>
        </div>
    @endforeach

</div>

{{-- レビュー星評価 --}}
    <script>
        $(document).ready(function() {
            var rating = 0;

            $('.star-btn').on('click', function() {
                rating = $(this).data('value');
                $('#ratingValue').val(rating);
                updateStars(rating);
            });

            $('.star-btn').hover(
                function() {
                    var hoverValue = $(this).data('value');
                    updateStars(hoverValue, true);
                },
                function() {
                    updateStars(rating);
                }
            );

            $('#submitReview').on('click', function() {
                if (rating === 0) {
                    alert('評価を選択してください。');
                } else {
                    $('#ratingForm').submit();
                }
            });

            function updateStars(value, isHover = false) {
                $('.star-btn').each(function() {
                    var starValue = $(this).data('value');
                    if (starValue <= value) {
                        $(this).addClass(isHover ? 'hover' : 'selected').removeClass(isHover ? 'selected' : 'hover');
                    } else {
                        $(this).removeClass('selected hover');
                    }
                });
            }
        });
    </script>

@endsection
