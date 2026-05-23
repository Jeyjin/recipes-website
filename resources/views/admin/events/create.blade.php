@extends('layouts.app')

@section('title', 'Добавить мероприятие - Админка')

@section('content')
    <h1>Добавить мероприятие</h1>

    <div class="row">
        <div class="col-md-6">
            <div class="info-block">
                <form action="{{ route('admin.events.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Название</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Описание</label>
                        <textarea name="description" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Дата проведения</label>
                        <input type="text" name="date" class="form-control" placeholder="например: Каждую субботу в 18:00" required>
                    </div>
                    <button class="btn btn-success">Сохранить</button>
                    <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">Отмена</a>
                </form>
            </div>
        </div>
    </div>
@endsection