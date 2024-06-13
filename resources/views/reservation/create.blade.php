@extends('layouts.app')

@section('content')

<div class="container">

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h3>予約フォーム</h3>

    <hr>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('reservation.store') }}" method="POST" id="reservationForm">
                @csrf
                @error('reservation_date')
                    <strong>予約の日時と時間を選択してください</strong>
                @enderror
                @error('number_of_people')
                    <strong>予約人数を入力してください</strong>
                @enderror

                <div class="mb-3 row align-items-center">
                    <label class="form-label col-md-4" for="reservation_date_input">予約の日時と時間を選択してください</label>
                    <div class="col-auto">
                        <input class="form-control" type="datetime-local" id="reservation_date_input" name="reservation_date" required></input>
                    </div>
                </div>
                <div class="mb-3 row align-items-center">
                    <label class="form-label col-md-4" for="number_of_people">予約人数を入力してください</label>
                    <div class="col-auto">
                        <input type="number" id="number_of_people" name="number_of_people" class="form-control" min="1" required></input>
                    </div>
                    <div class="col-auto">名</div>
                </div>

                <input type="hidden" name="store_id" value="{{ $store_id }}">

                <button type="submit" class="btn btn-warning" id="submitReservation">予約する</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('reservationForm').addEventListener('submit', function(event) {
        var selectedDate = new Date(document.getElementById('reservation_date_input').value);
        var currentDate = new Date();
        if (selectedDate < currentDate) {
            event.preventDefault(); // フォームの送信をキャンセル
            alert('過去の日付は予約できません。'); // エラーメッセージを表示
        }
    });
</script>

@endsection
