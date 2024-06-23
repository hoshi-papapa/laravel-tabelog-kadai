@extends('layouts.app')

@section('content')


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">NAGOYAMESHI管理者ログインページ</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('custom-admin-login') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="username" class="form-label">ユーザー名</label>
                                <input type="text" name="username" id="username" class="form-control" required>
                                @error('username')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">パスワード</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">ログイン</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection