@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-rose-800 mb-6">Панель администратора</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white/80 rounded-2xl p-6 border border-rose-100">
            <div class="text-3xl font-bold text-rose-600">{{ $usersCount }}</div>
            <div class="text-rose-400 mt-1">Пользователей</div>
            <a href="{{ route('admin.users') }}" class="inline-block mt-3 text-sm text-rose-500 hover:text-rose-600">Управление →</a>
        </div>
        
        <div class="bg-white/80 rounded-2xl p-6 border border-rose-100">
            <div class="text-3xl font-bold text-rose-600">{{ $recipesCount }}</div>
            <div class="text-rose-400 mt-1">Рецептов</div>
            <a href="{{ route('admin.recipes') }}" class="inline-block mt-3 text-sm text-rose-500 hover:text-rose-600">Управление →</a>
        </div>
        
        <div class="bg-white/80 rounded-2xl p-6 border border-rose-100">
            <div class="text-3xl font-bold text-rose-600">{{ $favoritesCount }}</div>
            <div class="text-rose-400 mt-1">Избранных рецептов</div>
        </div>
    </div>
</div>
@endsection