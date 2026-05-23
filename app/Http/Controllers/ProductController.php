<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $categoryId = $request->get('category');
        
        $products = Product::query();
        
        // Фильтр по категории
        if ($categoryId) {
            $products->where('category_id', $categoryId);
        }
        
        // Фильтр по новинкам
        if ($request->has('new')) {
            $products->where('is_new', true);
        }
        
        // Сортировка по цене
        if ($request->get('sort') == 'price_asc') {
            $products->orderBy('price', 'asc');
        } elseif ($request->get('sort') == 'price_desc') {
            $products->orderBy('price', 'desc');
        }
        
        $products = $products->get();

        return view('menu', compact('categories', 'products', 'categoryId'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('product', compact('product'));
    }
}