@extends('layouts.app')

@section('title', 'Управление отзывами - Админка')

@section('content')
    <h1>Управление отзывами</h1>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Пользователь</th>
                    <th>Отзыв</th>
                    <th>Оценка</th>
                    <th>Статус</th>
                    <th>Дата</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reviews as $review)
                    <tr>
                        <td>{{ $review->id }}</td>
                        <td>{{ $review->user->name }}</td>
                        <td>{{ $review->text }}</td>
                        <td>{{ $review->rating }}/5</td>
                        <td>
                            @if($review->status == 'moderation')
                                <span class="badge bg-warning text-dark">На модерации</span>
                            @elseif($review->status == 'approved')
                                <span class="badge bg-success">Одобрен</span>
                            @else
                                <span class="badge bg-danger">Отклонён</span>
                            @endif
                        </td>
                        <td>{{ $review->created_at->format('d.m.Y') }}</td>
                        <td>
                            @if($review->status == 'moderation')
                                <form action="{{ route('admin.reviews.approve', $review->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-success">Одобрить</button>
                                </form>
                                <form action="{{ route('admin.reviews.reject', $review->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-warning">Отклонить</button>
                                </form>
                            @endif
                            <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Удалить отзыв?')">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection