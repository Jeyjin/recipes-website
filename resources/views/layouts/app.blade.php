<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Кофе и Книги — уютная кофейня')</title>
    <meta name="description" content="@yield('description', 'Кофейня Кофе и Книги — ароматный кофе, свежая выпечка и уютная атмосфера. Меню, мероприятия, отзывы.')">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="preload" as="image" href="{{ asset('images/cappuccino.png') }}">
</head>
<body>
    <!-- Верхняя полоса -->
    <div class="top-bar">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <a class="navbar-brand" href="{{ route('home') }}">Кофе и Книги</a>
                <div class="d-flex align-items-center gap-2">
                    <a href="tel:{{ \App\Helpers\SettingsHelper::getPhone() }}" class="phone-btn">Позвонить</a>
                    <a href="{{ route('cart') }}" class="btn btn-outline-light btn-sm">Корзина</a>
                    @auth
                        <a href="{{ route('profile') }}" class="btn btn-outline-light btn-sm">{{ auth()->user()->name }}</a>
                        <form method="POST" action="/logout" class="d-inline">
                            @csrf
                            <button class="btn btn-outline-light btn-sm">Выйти</button>
                        </form>
                    @else
                        <a href="/login" class="btn btn-outline-light btn-sm">Войти</a>
                        <a href="/register" class="btn btn-outline-light btn-sm">Регистрация</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Нижняя полоса (меню) -->
    <nav class="navbar navbar-expand-lg main-nav">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Главная</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">О нас</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('menu') }}">Меню</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('events') }}">Мероприятия</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('reviews.index') }}">Отзывы</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('contacts') }}">Контакты</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @yield('content')
    </div>

    <footer>
        <div class="container text-center">
            <p style="margin:0;">Кофе и Книги &copy; 2026</p>
            <p style="margin:0; font-size:0.9rem;">ул. Примерная, д. 42 | +7 (999) 123-45-67 | Пн-Вс 8:00-23:00</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>