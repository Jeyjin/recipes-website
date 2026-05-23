@extends('layouts.app')

@section('title', 'Корзина — Кофе и Книги')
@section('description', 'Корзина заказов кофейни Кофе и Книги. Оформите заказ онлайн.')

@section('content')
    <h1>Корзина</h1>

    @if(count($products) > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Товар</th>
                    <th>Цена</th>
                    <th>Количество</th>
                    <th>Сумма</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->price }} ₽</td>
                        <td>
                            <form action="{{ route('cart.update') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="number" name="quantity" value="{{ $product->quantity }}" min="1" style="width:60px">
                                <button class="btn btn-sm btn-primary">Обновить</button>
                            </form>
                        </td>
                        <td>{{ $product->price * $product->quantity }} ₽</td>
                        <td>
                            <form action="{{ route('cart.remove') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button class="btn btn-sm btn-danger">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h3>Итого: {{ $total }} ₽</h3>

        @auth
            <a href="{{ route('order.create') }}" class="btn btn-success btn-lg">Оформить заказ</a>
        @else
            <p>Чтобы оформить заказ, <a href="{{ route('login') }}">войдите</a> или <a href="{{ route('register') }}">зарегистрируйтесь</a>.</p>
        @endauth
    @else
        <p>Корзина пуста. <a href="{{ route('menu') }}">Перейти в меню</a></p>
    @endif
@endsection