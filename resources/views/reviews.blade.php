@extends('layouts.app')

@section('description', 'Отзывы о кофейне Кофе и Книги. Оставьте свой отзыв и оцените нас по пятибалльной шкале.')

@section('content')
    <h1>Отзывы</h1>

    @auth
        <div class="info-block mb-4">
            <h4>Оставить отзыв</h4>
            <form action="{{ route('reviews.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Ваш отзыв</label>
                    <textarea name="text" class="form-control" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Оценка</label>
                    <select name="rating" class="form-select" required>
                        <option value="5">5 — Отлично</option>
                        <option value="4">4 — Хорошо</option>
                        <option value="3">3 — Нормально</option>
                        <option value="2">2 — Так себе</option>
                        <option value="1">1 — Плохо</option>
                    </select>
                </div>
                <button class="btn btn-success">Отправить</button>
                <small style="display:block; margin-top:8px; color: var(--coffee-medium);">Отзыв появится после проверки администратором</small>
            </form>
        </div>
    @else
        <div class="info-block mb-4 text-center">
            <p>Чтобы оставить отзыв, <a href="/login">войдите</a> или <a href="/register">зарегистрируйтесь</a>.</p>
        </div>
    @endauth

    @foreach($reviews as $review)
        <div class="info-block mb-3" itemprop="review" itemscope itemtype="https://schema.org/Review">
            <div class="d-flex justify-content-between">
                <strong itemprop="author" itemscope itemtype="https://schema.org/Person">
                    <span itemprop="name">{{ $review->user->name }}</span>
                </strong>
                <span style="color: var(--pink-dark);" itemprop="reviewRating" itemscope itemtype="https://schema.org/Rating">
                    <meta itemprop="ratingValue" content="{{ $review->rating }}">
                    <meta itemprop="bestRating" content="5">
                    @for($i = 0; $i < $review->rating; $i++) ★ @endfor
                    @for($i = $review->rating; $i < 5; $i++) ☆ @endfor
                </span>
            </div>
            <p class="mt-2" itemprop="reviewBody">{{ $review->text }}</p>
            <small style="color: var(--coffee-light);">
                <meta itemprop="datePublished" content="{{ $review->created_at->toDateString() }}">
                {{ $review->created_at->format('d.m.Y') }}
            </small>
        </div>
    @endforeach
@endsection