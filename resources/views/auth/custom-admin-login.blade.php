<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>管理者ログインページ</title>
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon"/>

        @vite('resources/css/app.css')
        @vite('resources/js/app.js')

        {{-- Bootstrap --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        
        {{-- Font Awesome --}}
        <script src="https://kit.fontawesome.com/68697ef03c.js" crossorigin="anonymous"></script>

        {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
        <link href="{{ asset('css/nagoyameshi.css') }}" rel="stylesheet">
        <link href="{{ asset('css/stripe.css') }}" rel="stylesheet">

        {{-- Scripts (stripeの絡みがあるのでscriptはこちらに記述する --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
        {{-- <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script> --}}

        {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- Script to remove specific stylesheet link tag -->
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const links = document.getElementsByTagName('link');
                for (let i = 0; i < links.length; i++) {
                    if (links[i].rel === 'stylesheet' && links[i].href === 'https://nagoyameshi-hoshi-b940707078bf.herokuapp.com/build/assets/app.css') {
                        links[i].parentNode.removeChild(links[i]);
                    }
                }
            });
        </script>
    </head>
    <body>
        <div id="app">
            <nav class="navbar navbar-expand-md navbar-light bg-warning shadow-sm mb-3">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('/stores') }}">
                        <img src="{{ asset('img/logo.jpg') }}" style="height: 40px; ">
                    </a>                
                </div>
            </nav>

            <main class="py-1" style="min-height: calc(100vh - 9.6rem);">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
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
            </main>

            <footer class="bg-warning text-dark text-center py-3 mt-3">
                <div class="container">
                    <p class="mb-0">&copy; 2024 NAGOYAMESHI. All rights reserved.</p>
                </div>
            </footer>

            <!-- Scripts -->
            <script src="https://js.stripe.com/v3/"></script>
        </div>
    </body>
</html>
