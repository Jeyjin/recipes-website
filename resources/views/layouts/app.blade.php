<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>RefriCook | Рецепты из холодильника</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="{{ asset('js/recipe-app.js') }}"></script>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Quicksand', sans-serif; }
        body { background: linear-gradient(135deg, #fff5f5 0%, #fff0f0 100%); }
        .gradient-text { background: linear-gradient(135deg, #FF6B6B 0%, #FF8E8E 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .btn-primary { background: linear-gradient(135deg, #FF6B6B 0%, #FF8E8E 100%); transition: all 0.3s ease; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 10px 20px -8px rgba(255, 107, 107, 0.4); }
        .recipe-card { transition: all 0.3s ease; background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); }
        .recipe-card:hover { transform: translateY(-5px); background: white; box-shadow: 0 20px 30px -12px rgba(255, 107, 107, 0.15); }
        .heart-btn { transition: transform 0.2s ease; }
        .heart-btn:hover { transform: scale(1.1); }
    </style>
    @stack('styles')
</head>
<body>
    <header class="bg-white/80 backdrop-blur-md border-b border-rose-100 sticky top-0 z-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex justify-between items-center">
                <a href="{{ route('home') }}" class="text-2xl font-bold gradient-text">RefriCook</a>
                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ route('profile') }}" class="text-rose-500 hover:text-rose-700 text-sm font-medium">{{ Auth::user()->login }}</a>
                        @if(Auth::user()->is_admin == 1)
                            <a href="{{ route('admin') }}" class="px-3 py-1.5 bg-rose-500 text-white rounded-lg text-sm hover:bg-rose-600 transition">Админка</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-rose-400 hover:text-rose-600 text-sm">Выйти</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-rose-500 hover:text-rose-600 text-sm">Войти</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 btn-primary text-white rounded-lg text-sm">Регистрация</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <main class="min-h-screen">
        @yield('content')
    </main>

    <footer class="bg-white/80 backdrop-blur-sm border-t border-rose-100 mt-12">
        <div class="max-w-7xl mx-auto px-4 py-6 text-center">
            <p class="text-rose-400 text-sm">© 2026 RefriCook. Готовим с любовью ❤️</p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>