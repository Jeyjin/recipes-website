<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация | RefriCook</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Quicksand', sans-serif; }
        body { background: linear-gradient(135deg, #fff5f5 0%, #fff0f0 100%); }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-sm border border-rose-100 p-8 max-w-md w-full">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold bg-gradient-to-r from-rose-600 to-rose-400 bg-clip-text text-transparent">RefriCook</h1>
            <p class="text-rose-400 mt-2">Создайте аккаунт</p>
        </div>
        
        @if ($errors->any())
            <div class="bg-rose-50 border border-rose-200 text-rose-600 px-4 py-3 rounded-lg mb-4 text-sm">
                {{ $errors->first() }}
            </div>
        @endif
        
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-rose-700 text-sm mb-2">Логин</label>
                <input type="text" name="login" value="{{ old('login') }}" required
                    class="w-full px-4 py-2 border border-rose-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-300">
            </div>
            
            <div class="mb-4">
                <label class="block text-rose-700 text-sm mb-2">Пароль</label>
                <input type="password" name="password" required
                    class="w-full px-4 py-2 border border-rose-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-300">
            </div>
            
            <div class="mb-6">
                <label class="block text-rose-700 text-sm mb-2">Подтвердите пароль</label>
                <input type="password" name="password_confirmation" required
                    class="w-full px-4 py-2 border border-rose-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-300">
            </div>
            
            <button type="submit" class="w-full bg-gradient-to-r from-rose-500 to-rose-400 text-white py-2 rounded-lg font-medium hover:shadow-lg transition">
                Зарегистрироваться
            </button>
        </form>
        
        <p class="text-center text-rose-400 text-sm mt-6">
            Уже есть аккаунт? 
            <a href="{{ route('login') }}" class="text-rose-600 hover:underline">Войти</a>
        </p>
    </div>
</body>
</html>