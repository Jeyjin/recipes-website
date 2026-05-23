<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Event;

class StatController extends Controller
{
    public function index()
    {
        // Продажи
        $totalOrders = Order::count();
        $totalRevenue = 0;
        $orders = Order::with('items')->get();
        foreach ($orders as $order) {
            foreach ($order->items as $item) {
                $totalRevenue += $item->price * $item->quantity;
            }
        }

        // Статусы заказов
        $newOrders = Order::where('status', 'Новый')->count();
        $completedOrders = Order::where('status', 'Выдан')->count();

        // Пользователи
        $totalUsers = User::count();
        $subscribedUsers = User::where('subscribed', true)->count();

        // Мероприятия
        $totalEvents = Event::count();

        return view('admin.stat', compact(
            'totalOrders', 'totalRevenue', 'newOrders', 'completedOrders',
            'totalUsers', 'subscribedUsers', 'totalEvents'
        ));
    }
}