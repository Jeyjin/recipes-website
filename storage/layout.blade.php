<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Лили Роуз</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @stack('styles')
</head>
<body>
    <div class="container-xxl">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('landing.home') }}">Лили Роуз</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <a class="nav-link{{ request()->routeIs('landing.catalog') ? ' active' : '' }}" href="{{ route('landing.catalog') }}">Каталог</a>
                        <a class="nav-link{{ request()->routeIs('landing.contact') ? ' active' : '' }}" href="{{ route('landing.contact') }}">Где мы находимся?</a>
                        @auth
                            <a class="nav-link{{ request()->routeIs('landing.cart') ? ' active' : '' }}" href="{{ route('landing.cart') }}">
                                Корзина
                            </a>
                        @endauth
                    </div>
                </div>
                @auth
                    <div class="d-flex gap-2">
                        <a class="btn btn-outline-secondary" href="{{ route('landing.profile') }}">Профиль</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-dark">Выйти</button>
                        </form>
                    </div>
                @else
                    <div class="d-flex gap-2">
                        <a class="btn btn-outline-secondary" href="{{ route('login') }}">Войти</a>
                        <a class="btn btn-dark" href="{{ route('register') }}">Регистрация</a>
                    </div>
                @endauth
            </div>
        </nav>
    </div>
    <main class="py-4">
        @yield('content')
    </main>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    @auth
        <script src="{{ asset('js/landing/cart-actions.js') }}" defer></script>
    @endauth
    @stack('scripts')
</body>
</html>

