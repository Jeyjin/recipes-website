@extends('layouts.app')

@section('content')
<div x-data="recipeApp()" x-init="init()" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Холодильник -->
    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-sm border border-rose-100 p-6 mb-8">
        <h2 class="text-xl font-semibold text-rose-800 mb-4">Мой холодильник</h2>
        <div class="flex flex-col sm:flex-row gap-3 mb-4">
            <select x-model="selectedProduct" class="flex-1 px-4 py-3 border border-rose-200 rounded-xl bg-white">
                <option value="">Выберите продукт...</option>
                @foreach($ingredients as $ingredient)
                    <option value="{{ $ingredient->name }}">{{ $ingredient->name }}</option>
                @endforeach
            </select>
            <button @click="addProduct()" class="btn-primary px-6 py-3 rounded-xl text-white font-medium">+ Добавить</button>
        </div>
        <div class="flex flex-wrap gap-2">
            <template x-for="product in myIngredients" :key="product">
                <div class="bg-rose-50 text-rose-700 px-4 py-2 rounded-xl flex items-center gap-2 text-sm border border-rose-200">
                    <span x-text="product"></span>
                    <button @click="removeProduct(product)" class="text-rose-300 hover:text-rose-500">&times;</button>
                </div>
            </template>
            <div x-show="myIngredients.length === 0" class="text-rose-300 text-sm">Добавьте продукты</div>
        </div>
    </div>

    <!-- Поиск -->
    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-sm border border-rose-100 p-6 mb-8">
        <h3 class="text-md font-semibold text-rose-800 mb-4">Режим поиска</h3>
        <div class="flex flex-wrap gap-4 mb-4">
            <label class="flex items-center gap-2"><input type="radio" value="all" x-model="searchMode" class="text-rose-500" checked> Показать всё</label>
            <label class="flex items-center gap-2"><input type="radio" value="partial" x-model="searchMode" class="text-rose-500"> 50%+ ингредиентов</label>
            <label class="flex items-center gap-2"><input type="radio" value="exact" x-model="searchMode" class="text-rose-500"> Точное совпадение</label>
        </div>
        <button @click="searchRecipes()" class="btn-primary w-full py-3 rounded-xl text-white font-medium">Найти рецепты</button>
    </div>

    <!-- Результаты -->
    <div>
        <h2 class="text-xl font-semibold text-rose-800 mb-4">Рецепты</h2>
        <div x-show="loading" class="text-center py-16">Загрузка...</div>
        <div x-show="!loading && recipes.length === 0 && searched" class="text-center py-16 text-rose-400">Ничего не найдено</div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <template x-for="recipe in displayedRecipes" :key="recipe.id">
                <div class="recipe-card rounded-2xl overflow-hidden border border-rose-100">
                    <div class="h-48 bg-gradient-to-br from-rose-200 to-rose-100 flex items-center justify-center relative overflow-hidden">
                        <img x-show="recipe.image" x-bind:src="recipe.image" alt="recipe.name" class="w-full h-full object-cover">
                        <span x-show="!recipe.image" class="text-6xl">🍲</span>
                        <button @click="toggleFavorite(recipe.id)" class="absolute bottom-3 right-3 heart-btn text-2xl focus:outline-none bg-white/50 rounded-full w-8 h-8 flex items-center justify-center backdrop-blur-sm">
                            <span x-show="isFavorite(recipe.id)" class="text-red-500">❤️</span>
                            <span x-show="!isFavorite(recipe.id)" class="text-gray-400 hover:text-red-400">🤍</span>
                        </button>
                    </div>
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-rose-900 mb-2" x-text="recipe.name"></h3>
                        <div class="flex justify-between text-sm text-rose-500 mb-3">
                            <span>⏱ <span x-text="recipe.time"></span> мин</span>
                            <span>Совпадение <span x-text="recipe.match_percent"></span>%</span>
                        </div>
                        <div class="w-full bg-rose-100 rounded-full h-1.5 mb-4">
                            <div class="bg-rose-500 h-1.5 rounded-full" :style="'width: ' + recipe.match_percent + '%'"></div>
                        </div>
                        <div class="mb-4">
                            <p class="text-xs font-semibold text-rose-500 mb-2">Ингредиенты:</p>
                            <div class="space-y-1">
                                <template x-for="ing in recipe.ingredients.slice(0, 3)" :key="ing.name">
                                    <div class="text-sm" :class="ing.have ? 'text-rose-700' : 'text-rose-300 line-through'">
                                        <span x-text="ing.name"></span>
                                        <span class="text-rose-400 text-xs ml-1" x-text="ing.amount"></span>
                                    </div>
                                </template>
                                <div x-show="recipe.ingredients.length > 3" class="text-xs text-rose-400">
                                    + ещё <span x-text="recipe.ingredients.length - 3"></span>
                                </div>
                            </div>
                        </div>
                        <button @click="showRecipeDetails(recipe)" class="w-full py-2 border border-rose-200 rounded-xl text-sm text-rose-600 hover:bg-rose-50">Подробнее</button>
                    </div>
                </div>
            </template>
        </div>
        
        <!-- Пагинация -->
        <div x-show="!loading && recipes.length > 0" class="mt-8 flex justify-center items-center gap-2 flex-wrap">
            <button @click="prevPage()" :disabled="currentPage === 1" class="px-4 py-2 rounded-lg border border-rose-200 text-rose-600 hover:bg-rose-50 disabled:opacity-50 disabled:cursor-not-allowed transition">← Назад</button>
            <template x-for="page in pages" :key="page">
                <button @click="currentPage = page; updateDisplayedRecipes(); scrollToTop()" class="px-4 py-2 rounded-lg transition" :class="currentPage === page ? 'bg-rose-500 text-white' : 'border border-rose-200 text-rose-600 hover:bg-rose-50'" x-text="page"></button>
            </template>
            <button @click="nextPage()" :disabled="currentPage === totalPages" class="px-4 py-2 rounded-lg border border-rose-200 text-rose-600 hover:bg-rose-50 disabled:opacity-50 disabled:cursor-not-allowed transition">Вперёд →</button>
        </div>
        <div x-show="!loading && recipes.length > 0" class="text-center text-sm text-rose-400 mt-4">
            Показано <span x-text="displayedRecipes.length"></span> из <span x-text="recipes.length"></span> рецептов
        </div>
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
                    <h3 class="text-md font-semibold text-rose-800 mb-3"> Ингредиенты</h3>
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
                    <h3 class="text-md font-semibold text-rose-800 mb-3"> Приготовление</h3>
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