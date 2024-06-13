@extends('layouts.app')

@section('content')

<div class="container">
    <h3>予約詳細</h3>
    <hr>
    <div class="row">
        <!-- 左側の画像カラム -->
        <div class="col-md-4">
            <div class="card">
                @if ($reservation->store->image)
                    <img src="{{ asset($reservation->store->image) }}" class="card-img-top">
                @else
                    <img src="{{ asset('img/dummy.png') }}" class="card-img-top">
                @endif
            </div>
        </div>
        
        <!-- 右側のテーブルカラム -->
        <div class="col-md-8">
            <div class="card-body">
                <h5 class="card-title">{{ $reservation->store->name }}</h5>

                <table class="table table-striped mt-2">
                    <thead>
                        <tr>
                            <th colspan="2" style="font-size: 1.2em;">予約情報</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row" style="width: 100px;">来店日時</th>
                            <td>{{ \Carbon\Carbon::parse($reservation->reservation_date)->format('Y年n月j日 G時i分') }}</td>
                        </tr>
                        <tr>
                            <th scope="row">予約人数</th>
                            <td>{{ $reservation->number_of_people }}名</td>
                        </tr>
                        <tr>
                            <th scope="row">予約日</th>
                            <td>{{ \Carbon\Carbon::parse($reservation->created_at)->format('Y年n月j日') }}</td>
                        </tr>
                    </tbody>
                </table>

                <table class="table table-striped mt-2">
                    <thead>
                        <tr>
                            <th colspan="2" style="font-size: 1.2em;">店舗情報</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row" style="width: 100px;">カテゴリ</th>
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
                            <th scope="row">説明</th>
                            <td>{{ $reservation->store->description }}</td>
                        </tr>
                        <tr>
                            <th scope="row">住所</th>
                            <td>{{ $reservation->store->Address }}</td>
                        </tr>
                        <tr>
                            <th scope="row">電話番号</th>
                            <td>{{ $reservation->store->phone_number }}</td>
                        </tr>
                        <tr>
                            <th scope="row">営業時間</th>
                            <td>{{ $reservation->store->business_hours }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
