<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $products = [];
        $total = 0;

        foreach ($cart as $id => $item) {
            $product = Product::find($id);
            if ($product) {
                $product->quantity = $item['quantity'];
                $products[] = $product;
                $total += $product->price * $item['quantity'];
            }
        }

        return view('cart', compact('products', 'total'));
    }

    public function add(Request $request)
    {
        $id = $request->product_id;
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = ['quantity' => 1];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Товар добавлен в корзину');
    }

    public function remove(Request $request)
    {
        $id = $request->product_id;
        $cart = session()->get('cart', []);
        unset($cart[$id]);
        session()->put('cart', $cart);
        return redirect()->back();
    }

    public function update(Request $request)
    {
        $id = $request->product_id;
        $cart = session()->get('cart', []);
        $cart[$id]['quantity'] = $request->quantity;
        session()->put('cart', $cart);
        return redirect()->back();
    }
}