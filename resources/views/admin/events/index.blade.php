@extends('layouts.app')

@section('title', 'Управление мероприятиями - Админка')

@section('content')
    <h1>Управление мероприятиями</h1>
    <a href="{{ route('admin.events.create') }}" class="btn btn-success mb-3">Добавить мероприятие</a>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Дата проведения</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach($events as $event)
                    <tr>
                        <td>{{ $event->id }}</td>
                        <td>{{ $event->title }}</td>
                        <td>{{ $event->date }}</td>
                        <td>
                            <a href="{{ route('admin.events.edit', $event->id) }}" class="btn btn-sm btn-primary">Изменить</a>
                            <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Удалить мероприятие?')">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection