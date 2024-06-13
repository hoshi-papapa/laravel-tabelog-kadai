@extends('layouts.app')

@section('content')
<div class="container">
  <h3>会員情報の編集</h3>

  <hr>

  <div class="d-flex justify-content-center py-3">
    <form method="POST" action="{{route('mypage.update_password')}}" class="w-100" style="max-width: 600px;">
        @csrf
        <input type="hidden" name="_method" value="PUT">

        <div class="form-group row justify-content-center">
            <label for="password" class="col-md-4 col-form-label text-md-right">新しいパスワード</label>
            <div class="col-md-6">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" style="max-width: 300px;">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <br>

        <div class="form-group row justify-content-center">
            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">確認用</label>
            <div class="col-md-6">
                <input type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" style="max-width: 300px;">
            </div>
        </div>
        
        <div class="form-group row mb-0 justify-content-center mt-5">
            <div class="col-md-8 text-center">
                <button type="submit" class="btn btn-warning">
                    パスワード更新
                </button>
            </div>
        </div>

    </form>
    </div>
</div>
@endsection