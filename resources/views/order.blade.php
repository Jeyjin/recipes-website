@extends('layouts.app')

@section('title', 'Оформление заказа - Кофе и Книги')

@section('content')
    <h1>Оформление заказа</h1>

    <form action="{{ route('order.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Тип получения</label>
            <select name="delivery_type" class="form-control">
                <option value="pickup">Самовывоз</option>
                <option value="delivery">Доставка</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Адрес (для доставки)</label>
            <input type="text" name="address" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Телефон</label>
            <input type="text" name="phone" class="form-control" required>
        </div>
        <button class="btn btn-success">Подтвердить заказ</button>
    </form>
@endsection