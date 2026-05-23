@extends('layouts.app')

@section('title', 'Изменить мероприятие - Админка')

@section('content')
    <h1>Изменить мероприятие</h1>

    <div class="row">
        <div class="col-md-6">
            <div class="info-block">
                <form action="{{ route('admin.events.update', $event->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Название</label>
                        <input type="text" name="title" class="form-control" value="{{ $event->title }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Описание</label>
                        <textarea name="description" class="form-control" rows="3" required>{{ $event->description }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Дата проведения</label>
                        <input type="text" name="date" class="form-control" value="{{ $event->date }}" required>
                    </div>
                    <button class="btn btn-success">Сохранить</button>
                    <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">Отмена</a>
                </form>
            </div>
        </div>
    </div>
@endsection