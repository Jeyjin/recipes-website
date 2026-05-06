@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-rose-800">Управление рецептами</h1>
        <div class="flex gap-3">
            <a href="{{ route('admin.recipes.create') }}" class="btn-primary px-4 py-2 rounded-lg text-white text-sm">+ Новый рецепт</a>
            <a href="{{ route('admin') }}" class="text-rose-500 hover:text-rose-600">← Назад</a>
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($recipes as $recipe)
        <div class="bg-white/80 rounded-2xl border border-rose-100 overflow-hidden">
            @if($recipe->image)
                <img src="{{ $recipe->image }}" alt="{{ $recipe->name }}" class="w-full h-40 object-cover">
            @else
                <div class="h-40 bg-gradient-to-br from-rose-200 to-rose-100 flex items-center justify-center">
                    <span class="text-5xl">🍲</span>
                </div>
            @endif
            <div class="p-4">
                <h3 class="font-bold text-rose-800">{{ $recipe->name }}</h3>
                <p class="text-sm text-rose-500 mt-1">⏱ {{ $recipe->time }} мин</p>
                <div class="mt-3 flex gap-2">
                    <a href="{{ route('admin.recipes.edit', $recipe->id) }}" class="flex-1 text-center py-1.5 border border-rose-200 rounded-lg text-sm text-rose-600 hover:bg-rose-50">Редактировать</a>
                    <button onclick="deleteRecipe({{ $recipe->id }})" class="px-3 py-1.5 border border-red-200 rounded-lg text-sm text-red-500 hover:bg-red-50">Удалить</button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<script>
function deleteRecipe(id) {
    if (confirm('Удалить рецепт?')) {
        fetch('/admin/recipes/' + id, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        }).then(() => location.reload());
    }
}
</script>
@endsection