@extends('layouts.app')

@section('title', 'Статистика - Админка')

@section('content')
    <h1>Статистика</h1>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="info-block text-center">
                <h3>{{ $totalOrders }}</h3>
                <p>Всего заказов</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="info-block text-center">
                <h3>{{ $totalRevenue }} руб.</h3>
                <p>Общая выручка</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="info-block text-center">
                <h3>{{ $newOrders }}</h3>
                <p>Новых заказов</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="info-block text-center">
                <h3>{{ $completedOrders }}</h3>
                <p>Выполнено заказов</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="info-block text-center">
                <h3>{{ $totalUsers }}</h3>
                <p>Пользователей</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="info-block text-center">
                <h3>{{ $subscribedUsers }}</h3>
                <p>Подписано на рассылку</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="info-block text-center">
                <h3>{{ $totalEvents }}</h3>
                <p>Мероприятий</p>
            </div>
        </div>
    </div>
@endsection