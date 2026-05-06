@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-rose-800">{{ isset($recipe) ? 'Редактировать рецепт' : 'Новый рецепт' }}</h1>
        <a href="{{ route('admin.recipes') }}" class="text-rose-500 hover:text-rose-600">← Назад</a>
    </div>
    
    <form method="POST" action="{{ isset($recipe) ? route('admin.recipes.update', $recipe->id) : route('admin.recipes.store') }}" class="bg-white/80 rounded-2xl border border-rose-100 p-6" enctype="multipart/form-data">
        @csrf
        @if(isset($recipe)) @method('PUT') @endif
        
        <!-- Название -->
        <div class="mb-4">
            <label class="block text-rose-700 mb-2">Название рецепта</label>
            <input type="text" name="name" required value="{{ old('name', $recipe->name ?? '') }}" class="w-full px-4 py-2 border border-rose-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-rose-300">
        </div>
        
        <!-- Время -->
        <div class="mb-4">
            <label class="block text-rose-700 mb-2">Время приготовления (минут)</label>
            <input type="number" name="time" required value="{{ old('time', $recipe->time ?? '') }}" class="w-full px-4 py-2 border border-rose-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-rose-300">
        </div>
        
        <!-- Drag & Drop картинка -->
        <div class="mb-4">
            <label class="block text-rose-700 mb-2">Изображение</label>
            
            @if(isset($recipe) && $recipe->image)
                <div id="current-image" class="mb-3">
                    <img src="{{ $recipe->image }}" class="h-32 rounded-lg object-cover">
                    <button type="button" onclick="document.getElementById('current-image').remove()" class="text-sm text-red-500 mt-1">Удалить изображение</button>
                </div>
            @endif
            
            <div id="dropzone" class="border-2 border-dashed border-rose-300 rounded-xl p-8 text-center cursor-pointer hover:border-rose-400 transition">
                <div id="dropzone-text" class="text-rose-400">
                    📸 Перетащите картинку сюда или нажмите для выбора
                </div>
                <input type="file" id="file-input" name="image" accept="image/*" class="hidden">
            </div>
            <div id="image-preview" class="mt-3 hidden">
                <img id="preview-img" src="" class="h-32 rounded-lg object-cover">
                <p class="text-sm text-green-600 mt-1">✓ Файл загружен</p>
            </div>
        </div>
        
        <!-- Ингредиенты -->
        <div class="mb-4">
            <label class="block text-rose-700 mb-2">Ингредиенты</label>
            <div class="grid grid-cols-2 gap-2 max-h-60 overflow-y-auto border border-rose-200 rounded-xl p-3">
                @foreach($ingredients as $ingredient)
                <label class="flex items-center gap-2 text-sm">
                    <input type="checkbox" name="ingredients[]" value="{{ $ingredient->id }}" 
                        {{ isset($recipe) && in_array($ingredient->id, $recipe->ingredients ?? []) ? 'checked' : '' }}
                        onchange="toggleAmount(this)">
                    <span>{{ $ingredient->name }}</span>
                    <input type="text" name="amounts[{{ $ingredient->id }}]" placeholder="количество" 
                        value="{{ isset($recipe) ? DB::table('ingredient_recipe')->where('recipe_id', $recipe->id)->where('ingredient_id', $ingredient->id)->value('amount') : '' }}"
                        class="w-24 px-2 py-1 text-xs border border-rose-200 rounded-lg ml-auto">
                </label>
                @endforeach
            </div>
        </div>
        
        <!-- Шаги приготовления -->
        <div class="mb-4">
            <label class="block text-rose-700 mb-2">Шаги приготовления</label>
            <div id="steps-container" class="space-y-2">
                @php
                    $steps = isset($recipe) ? $recipe->steps : [''];
                @endphp
                @foreach($steps as $index => $step)
                <div class="step-item flex gap-2">
                    <input type="text" name="steps[]" value="{{ $step }}" placeholder="Шаг {{ $index + 1 }}" class="flex-1 px-4 py-2 border border-rose-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-rose-300">
                    <button type="button" onclick="removeStep(this)" class="px-3 py-2 text-red-500 hover:bg-red-50 rounded-lg">✕</button>
                </div>
                @endforeach
            </div>
            <button type="button" onclick="addStep()" class="mt-2 text-sm text-rose-500 hover:text-rose-600">+ Добавить шаг</button>
        </div>
        
        <button type="submit" class="btn-primary w-full py-3 rounded-xl text-white font-medium">Сохранить</button>
    </form>
</div>

<script>
// Drag & Drop загрузка картинки
const dropzone = document.getElementById('dropzone');
const fileInput = document.getElementById('file-input');
const dropzoneText = document.getElementById('dropzone-text');
const imagePreview = document.getElementById('image-preview');
const previewImg = document.getElementById('preview-img');

dropzone.addEventListener('click', () => fileInput.click());
dropzone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropzone.classList.add('border-rose-500', 'bg-rose-50');
});
dropzone.addEventListener('dragleave', () => {
    dropzone.classList.remove('border-rose-500', 'bg-rose-50');
});
dropzone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropzone.classList.remove('border-rose-500', 'bg-rose-50');
    const file = e.dataTransfer.files[0];
    if (file && file.type.startsWith('image/')) {
        handleImageSelect(file);
    }
});
fileInput.addEventListener('change', (e) => {
    if (e.target.files[0]) {
        handleImageSelect(e.target.files[0]);
        // Отправляем форму сразу после выбора файла
        const formData = new FormData();
        formData.append('image', e.target.files[0]);
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
        
        @if(isset($recipe))
        fetch('/admin/recipes/{{ $recipe->id }}/image', {
            method: 'POST',
            body: formData
        });
        @endif
    }
});

function handleImageSelect(file) {
    const reader = new FileReader();
    reader.onload = function(e) {
        previewImg.src = e.target.result;
        imagePreview.classList.remove('hidden');
        dropzoneText.classList.add('hidden');
    };
    reader.readAsDataURL(file);
}

// Управление шагами
function addStep() {
    const container = document.getElementById('steps-container');
    const stepCount = container.children.length;
    const div = document.createElement('div');
    div.className = 'step-item flex gap-2';
    div.innerHTML = `
        <input type="text" name="steps[]" placeholder="Шаг ${stepCount + 1}" class="flex-1 px-4 py-2 border border-rose-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-rose-300">
        <button type="button" onclick="removeStep(this)" class="px-3 py-2 text-red-500 hover:bg-red-50 rounded-lg">✕</button>
    `;
    container.appendChild(div);
}

function removeStep(btn) {
    btn.parentElement.remove();
}

function toggleAmount(checkbox) {
    const amountInput = checkbox.parentElement.querySelector('input[type="text"]');
    amountInput.disabled = !checkbox.checked;
}
</script>
@endsection