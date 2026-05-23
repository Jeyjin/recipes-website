@extends('layouts.app')

@section('title', 'Личный кабинет - Кофе и Книги')

@section('content')
    <h1>Личный кабинет</h1>

    <!-- Админка -->
    @if(auth()->user()->is_admin)
        <div class="info-block mb-4">
            <h4 style="margin-bottom:15px;">Админка</h4>
            <a href="{{ route('admin.products.index') }}" class="btn btn-success me-2">Товары</a>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-success me-2">Заказы</a>
            <a href="{{ route('admin.reviews.index') }}" class="btn btn-success me-2">Отзывы</a>
            <a href="{{ route('admin.settings.index') }}" class="btn btn-success">Настройки</a>
            <a href="{{ route('admin.events.index') }}" class="btn btn-success me-2">Мероприятия</a>
            <a href="{{ route('admin.stat') }}" class="btn btn-success">Статистика</a>
        </div>
    @endif

    <!-- Профиль -->
    <div class="row">
        <div class="col-md-5">
            <div class="info-block mb-4">
                <h4>Мои данные</h4>
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Имя</label>
                        <input type="text" name="name" class="form-control" value="{{ auth()->user()->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ auth()->user()->email }}" required>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="subscribed" class="form-check-input" id="subscribed" {{ auth()->user()->subscribed ? 'checked' : '' }}>
                        <label class="form-check-label" for="subscribed">Подписка на новости, акции и анонсы мероприятий</label>
                    </div>
                    <button class="btn btn-success">Сохранить</button>
                </form>
            </div>
        </div>
    </div>

    <!-- История заказов -->
    <h3 style="margin-top: 30px;">Мои заказы</h3>

    @if($orders->count() > 0)
        @foreach($orders as $order)
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>Заказ №{{ $order->id }}</span>
                        <span>{{ $order->created_at->format('d.m.Y в H:i') }}</span>
                    </div>
                </div>
                <div class="card-body">
                    @foreach($order->items as $item)
                        <div class="d-flex justify-content-between" style="border-bottom:1px solid var(--beige); padding:8px 0;">
                            <span>{{ $item->product->name }} x{{ $item->quantity }}</span>
                            <span class="price">{{ $item->price * $item->quantity }} руб.</span>
                        </div>
                    @endforeach
                    <div class="mt-3 d-flex justify-content-between align-items-center">
                        <div>
                            <span class="badge bg-success">{{ $order->delivery_type == 'pickup' ? 'Самовывоз' : 'Доставка' }}</span>
                            <span style="margin-left:10px; color: var(--coffee-medium);">Статус: <strong>{{ $order->status }}</strong></span>
                        </div>
                        <a href="{{ route('order.repeat', $order->id) }}" class="btn btn-sm btn-primary">Повторить заказ</a>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="info-block text-center" style="padding:60px 20px;">
            <p style="font-size:1.2rem; color: var(--coffee-medium);">У вас пока нет заказов</p>
            <a href="{{ route('menu') }}" class="btn btn-success">Перейти в меню</a>
        </div>
    @endif
@endsection