<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

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
    </head>
    <body>
        <div id="app">
            @component('components.header')
            @endcomponent

            <main class="py-1" style="min-height: calc(100vh - 9.6rem);">
                @yield('content')
            </main>

            @component('components.footer')
            @endcomponent
        </div>

        <!-- Scripts -->
        <script src="https://js.stripe.com/v3/"></script>
        </body>
</html>
