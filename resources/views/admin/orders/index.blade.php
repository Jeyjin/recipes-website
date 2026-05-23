@extends('layouts.app')

@section('title', 'Управление заказами - Админка')

@section('content')
    <h1>Управление заказами</h1>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Клиент</th>
                    <th>Телефон</th>
                    <th>Тип</th>
                    <th>Сумма</th>
                    <th>Статус</th>
                    <th>Дата</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>{{ $order->phone }}</td>
                        <td>{{ $order->delivery_type == 'pickup' ? 'Самовывоз' : 'Доставка' }}</td>
                        <td>
                            @php
                                $total = 0;
                                foreach($order->items as $item) {
                                    $total += $item->price * $item->quantity;
                                }
                            @endphp
                            {{ $total }} руб.
                        </td>
                        <td>
                            <span class="badge bg-success">{{ $order->status }}</span>
                        </td>
                        <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                        <td>
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#orderModal{{ $order->id }}">
                                Сменить статус
                            </button>
                            <button class="btn btn-sm btn-success" onclick="alert('Уведомление отправлено клиенту на номер {{ $order->phone }}')">Уведомить</button>
                        </td>
                    </tr>

                    <!-- Модалка смены статуса -->
                    <div class="modal fade" id="orderModal{{ $order->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content" style="border-radius:15px;">
                                <div class="modal-header" style="background:var(--soft-pink); border-radius:15px 15px 0 0;">
                                    <h5>Заказ №{{ $order->id }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Товары:</strong></p>
                                    @foreach($order->items as $item)
                                        <p>{{ $item->product->name }} x{{ $item->quantity }} — {{ $item->price * $item->quantity }} руб.</p>
                                    @endforeach
                                    <p><strong>Адрес:</strong> {{ $order->address ?: 'Не указан' }}</p>
                                    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                                        @csrf
                                        <label class="form-label">Статус</label>
                                        <select name="status" class="form-select">
                                            <option {{ $order->status == 'Новый' ? 'selected' : '' }}>Новый</option>
                                            <option {{ $order->status == 'Готовится' ? 'selected' : '' }}>Готовится</option>
                                            <option {{ $order->status == 'Готов' ? 'selected' : '' }}>Готов</option>
                                            <option {{ $order->status == 'Выдан' ? 'selected' : '' }}>Выдан</option>
                                            <option {{ $order->status == 'Отменён' ? 'selected' : '' }}>Отменён</option>
                                        </select>
                                        <button class="btn btn-success mt-3">Сохранить</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection