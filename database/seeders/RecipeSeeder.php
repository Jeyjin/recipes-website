<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Ingredient;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function index()
    {
        $ingredients = Ingredient::orderBy('name')->get();
        return view('index', compact('ingredients'));
    }
    
    public function search(Request $request)
    {
        // Временно возвращаем простой ответ для отладки
        return response()->json(['test' => 'ok', 'ingredients' => $request->input('ingredients')]);
    }
}