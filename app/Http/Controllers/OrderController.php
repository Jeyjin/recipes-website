<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function create()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('menu')->with('error', 'Корзина пуста');
        }
        return view('order');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'delivery_type' => 'required',
            'address' => 'nullable',
            'phone' => 'required',
        ]);

        $cart = session()->get('cart', []);
        
        $order = Order::create([
            'user_id' => auth()->id(),
            'delivery_type' => $validated['delivery_type'],
            'address' => $validated['address'] ?? '',
            'phone' => $validated['phone'],
            'status' => 'Новый',
        ]);

        foreach ($cart as $id => $item) {
            $product = \App\Models\Product::find($id);
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $id,
                'quantity' => $item['quantity'],
                'price' => $product->price,
            ]);
        }

        session()->forget('cart');
        return redirect()->route('profile')->with('success', 'Заказ оформлен');
    }

    public function history()
    {
        $orders = Order::where('user_id', auth()->id())->latest()->get();
        return view('profile', compact('orders'));
    }

    public function profile()
{
    $orders = Order::where('user_id', auth()->id())->latest()->get();
    return view('profile', compact('orders'));
}

    public function updateProfile(Request $request)
{
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
        ]);

        auth()->user()->update([
            'name' => $request->name,
            'email' => $request->email,
            'subscribed' => $request->has('subscribed'),
        ]);

        return redirect()->route('profile')->with('success', 'Профиль обновлён');
}

    public function repeatOrder($id)
{
        $order = Order::where('user_id', auth()->id())->findOrFail($id);
        
        $cart = [];
        foreach ($order->items as $item) {
            $cart[$item->product_id] = ['quantity' => $item->quantity];
        }
        
        session()->put('cart', $cart);
        return redirect()->route('cart')->with('success', 'Товары из заказа добавлены в корзину');
}
}