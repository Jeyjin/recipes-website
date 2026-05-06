@extends('layouts.app')

@section('content')
<div x-data="recipeApp()" x-init="init()" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Информация о пользователе -->
    <div class="bg-white/80 backdrop-blur-sm rounded-2xl border border-rose-100 p-6 mb-8">
        <h1 class="text-2xl font-semibold text-rose-800 mb-4">Мой профиль</h1>
        <p class="text-rose-600"><strong>Логин:</strong> {{ $user->login }}</p>
        <p class="text-rose-600 mt-2"><strong>Дата регистрации:</strong> {{ $user->created_at->format('d.m.Y') }}</p>
    </div>

    <!-- Избранные рецепты -->
    <div>
        <h2 class="text-xl font-semibold text-rose-800 mb-4">Избранные рецепты</h2>
        
        @if($favorites->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($favorites as $recipe)
                    <div class="recipe-card rounded-2xl overflow-hidden border border-rose-100">
                        <div class="h-48 bg-gradient-to-br from-rose-200 to-rose-100 flex items-center justify-center relative overflow-hidden">
                            @if($recipe->image)
                                <img src="{{ $recipe->image }}" alt="{{ $recipe->name }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-6xl">🍲</span>
                            @endif
                            <button @click="toggleFavorite({{ $recipe->id }})" class="absolute bottom-3 right-3 heart-btn text-2xl focus:outline-none bg-white/50 rounded-full w-8 h-8 flex items-center justify-center backdrop-blur-sm">
                                <span x-show="isFavorite({{ $recipe->id }})" class="text-red-500">❤️</span>
                                <span x-show="!isFavorite({{ $recipe->id }})" class="text-gray-400 hover:text-red-400">🤍</span>
                            </button>
                        </div>
                        <div class="p-5">
                            <h3 class="text-lg font-bold text-rose-900 mb-2">{{ $recipe->name }}</h3>
                            <div class="text-sm text-rose-500 mb-3">
                                <span>⏱ {{ $recipe->time }} минут</span>
                            </div>
                            
                            <!-- Ингредиенты -->
                            <div class="mb-4">
                                <p class="text-xs font-semibold text-rose-500 mb-2">Ингредиенты:</p>
                                <div class="space-y-1">
                                    @foreach($recipe->ingredients->take(3) as $ing)
                                        <div class="text-sm text-rose-700">
                                            <span>{{ $ing->name }}</span>
                                            <span class="text-rose-400 text-xs ml-1">{{ $ing->amount }}</span>
                                        </div>
                                    @endforeach
                                    @if($recipe->ingredients->count() > 3)
                                        <div class="text-xs text-rose-400">
                                            + ещё {{ $recipe->ingredients->count() - 3 }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <button @click="showRecipeDetails({
                                id: {{ $recipe->id }},
                                name: '{{ $recipe->name }}',
                                time: {{ $recipe->time }},
                                match_percent: 100,
                                ingredients: {{ json_encode($recipe->ingredients->map(function($ing) {
                                    return ['name' => $ing->name, 'amount' => $ing->amount, 'have' => true];
                                })) }},
                                steps: {{ json_encode($recipe->steps) }}
                            })" class="w-full py-2 border border-rose-200 rounded-xl text-sm text-rose-600 hover:bg-rose-50">
                                 Подробнее
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16 bg-white/60 rounded-2xl border border-rose-100">
                <p class="text-rose-400"> У вас пока нет избранных рецептов</p>
                <a href="/" class="inline-block mt-4 px-6 py-2 btn-primary text-white rounded-lg">Найти рецепты</a>
            </div>
        @endif
    </div>

    <!-- Модалка -->
    <div x-show="selectedRecipe" class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display: none;">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="selectedRecipe = null"></div>
        <div class="relative bg-white rounded-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto shadow-2xl">
            <div class="sticky top-0 bg-white/95 backdrop-blur-sm border-b border-rose-100 px-6 py-4 flex justify-between items-center rounded-t-2xl">
                <h2 class="text-xl font-bold text-rose-800" x-text="selectedRecipe?.name"></h2>
                <button @click="selectedRecipe = null" class="text-rose-300 hover:text-rose-500 text-3xl leading-none">&times;</button>
            </div>
            <div class="p-6">
                <div class="flex gap-4 text-sm text-rose-500 mb-6 pb-3 border-b border-rose-100">
                    <span>⏱ <span x-text="selectedRecipe?.time"></span> минут</span>
                    <span> Совпадение <span x-text="selectedRecipe?.match_percent"></span>%</span>
                </div>
                <div class="mb-6">
                    <h3 class="text-md font-semibold text-rose-800 mb-3">Ингредиенты</h3>
                    <ul class="space-y-2">
                        <template x-for="ing in selectedRecipe?.ingredients" :key="ing.name">
                            <li class="text-sm" :class="ing.have ? 'text-gray-700' : 'text-gray-400 line-through'">
                                <span class="font-medium" x-text="ing.name"></span>
                                <span class="text-rose-400 ml-2" x-text="ing.amount"></span>
                            </li>
                        </template>
                    </ul>
                </div>
                <div>
                    <h3 class="text-md font-semibold text-rose-800 mb-3">Приготовление</h3>
                    <ol class="list-decimal list-inside space-y-2">
                        <template x-for="(step, stepIndex) in (selectedRecipe?.steps || [])" :key="stepIndex">
                            <li class="text-sm text-gray-600" x-text="step"></li>
                        </template>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection