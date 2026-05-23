@extends('layouts.app')

@section('title', 'Добавить товар - Админка')

@section('content')
    <h1>Добавить товар</h1>

    <div class="row">
        <div class="col-md-6">
            <div class="info-block">
                <form action="{{ route('admin.products.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Название</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Описание</label>
                        <textarea name="description" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Цена (руб.)</label>
                        <input type="number" name="price" class="form-control" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Категория</label>
                        <select name="category_id" class="form-select" required>
                            <option value="">Выберите категорию</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="is_new" class="form-check-input" id="is_new">
                        <label class="form-check-label" for="is_new">Новинка</label>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Имя файла картинки</label>
                        <input type="text" name="image" class="form-control" placeholder="например: cappuccino.jpg">
                        <small style="color: var(--coffee-light);">Загрузи картинку в папку public/images/ и укажи имя файла</small>
                    </div>
                    <button class="btn btn-success">Сохранить</button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Отмена</a>
                </form>
            </div>
        </div>
    </div>
@endsection