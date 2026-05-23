@extends('layouts.app')

@section('title', 'Изменить товар - Админка')

@section('content')
    <h1>Изменить товар</h1>

    <div class="row">
        <div class="col-md-6">
            <div class="info-block">
                <form action="{{ route('admin.products.update', $product->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Название</label>
                        <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Описание</label>
                        <textarea name="description" class="form-control" rows="3" required>{{ $product->description }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Цена (руб.)</label>
                        <input type="number" name="price" class="form-control" step="0.01" value="{{ $product->price }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Категория</label>
                        <select name="category_id" class="form-select" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="is_new" class="form-check-input" id="is_new" {{ $product->is_new ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_new">Новинка</label>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Имя файла картинки</label>
                        <input type="text" name="image" class="form-control" value="{{ $product->image }}" placeholder="например: cappuccino.jpg">
                        <small style="color: var(--coffee-light);">Загрузи картинку в папку public/images/ и укажи имя файла</small>
                    </div>
                    <button class="btn btn-success">Сохранить</button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Отмена</a>
                </form>
            </div>
        </div>
    </div>
@endsection