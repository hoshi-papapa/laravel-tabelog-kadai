@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row align-items-center">
        {{-- パンくずリスト --}}
        <div class="col-md-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb" style="font-size: 1.1rem;">
                    <li class="breadcrumb-item"><a href="{{ route('stores.index') }}">全てのお店</a></li>
                    @if( $selected_category !== null )
                        <li class="breadcrumb-item">{{ $selected_category->name }}</li>
                    @elseif ($keyword !== null)
                        <li class="breadcrumb-item">お店一覧</li>
                    @endif
                </ol>
            </nav>
        </div>

        {{-- 検索ボックスと並び替え --}}
        <div class="col-md-9">
            <div class="row">
                {{-- 検索ボックス --}}
                <div class="col-auto mb-3">
                    <form action="{{ route('stores.index') }}" method="GET" class="row g-1 align-items-center">
                        <div class="col-auto">
                            <input class="form-control" name="keyword" placeholder="キーワードを入力" value="{{ request('keyword') }}">
                        </div>
                        <div class="col-auto">
                            <select class="form-select" name="category">
                                <option value="">全てのカテゴリ</option>
                                @foreach ($allcategories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-search" style="color:black;"></i>
                            </button>
                        </div>
                    </form>
                </div>

                {{-- 並び替え --}}
                <div class="col-auto mb-3">
                    <div class="d-flex align-items-center">
                        <span class="me-2">並び替え</span>
                        <form method="GET" action="{{ route('stores.index') }}" class="d-inline">
                            @if ($selected_category)
                                <input type="hidden" name="category" value="{{ $selected_category->id }}">
                            @endif
                            <input type="hidden" name="keyword" value="{{ request('keyword') }}">
                            <select class="form-select" name="select_sort" onChange="this.form.submit();">
                                @foreach ($sorts as $value => $key)
                                    @if ($sorted === $value)
                                        <option value="{{ $value }}" selected>{{ $key }}</option>
                                    @else
                                        <option value="{{ $value }}">{{ $key }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ランダムなカテゴリを表示するチップ --}}
    <div class="row">
        <div style="font-size: 20px;">
            @foreach ($categories as $category)
                <span>
                    <a class="badge text-bg-warning" href="{{ route('stores.index', ['category' => $category->id]) }}" style="text-decoration: none;">{{ $category->name }}</a>
                </span>
            @endforeach
        </div>
    </div>

    <hr>

    {{-- 検索結果の表示 --}}
    <div class="container mt-3">
        @if($selected_category && $keyword)
            <h4 class="mt-3">「{{ $selected_category->name }}」カテゴリ / 「{{ $keyword }}」の検索結果　{{ $total_count }}件</h4>
            @if ($total_count == 0)
                <p class="mt-3">申し訳ございません。「{{ $selected_category->name }}」カテゴリ / 「{{ $keyword }}」のお店はありませんでした。</p>
            @endif
        @elseif($selected_category)
            <h4 class="mt-3">「{{ $selected_category->name }}」カテゴリの検索結果　{{ $total_count }}件</h4>
            @if ($total_count == 0)
                <p class="mt-3">申し訳ございません。「{{ $selected_category->name }}」カテゴリのお店はありませんでした。</p>
            @endif
        @elseif($keyword)
            <h4 class="mt-3">「{{ $keyword }}」の検索結果　{{ $total_count }}件</h4>
            @if ($total_count == 0)
                <p class="mt-3">申し訳ございません。「{{ $keyword }}」のお店はありませんでした。</p>
            @endif
        @endif
    </div>

    {{-- 店舗一覧表示 --}}
    <div class="container mt-4">
        @foreach($stores as $store)
            <a href="{{route('stores.show', $store)}}" style="text-decoration: none;">
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-md-4">
                            @if ($store->image !== "")
                                <img src="{{ asset($store->image) }}" class="img-thumbnail">
                            @else
                                <img src="{{ asset('img/dummy.png')}}" class="img-thumbnail">
                            @endif
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">{{$store->name}}</h5>
                                @if ($store->average_review)
                                    <div style="display: flex; align-items: center;" class="mb-2">
                                        <div class="star-rating" data-rate={{ round($store->average_review * 2) /2 }}></div>
                                        <div class="rating" style="font-size: 1rem;">　{{ number_format(round($store->average_review, 1), 1) }}</div>
                                    </div>
                                @else
                                    <div style="display: flex; align-items: center;" class="mb-2">
                                        <div class="star-rating" data-rate={{ round($store->average_review * 2) /2 }}></div>
                                        <div class="rating">　－</div>
                                    </div>
                                @endif
                                <p class="card-text">{{$store->description}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
        
        {{-- ページネーション --}}
        {{ $stores->appends(request()->query())->links() }}
    </div>
</div>

@endsection