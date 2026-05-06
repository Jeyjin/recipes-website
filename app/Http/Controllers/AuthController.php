<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    // Показать форму регистрации
    public function showRegister()
    {
        return view('register');
    }
    
    // Обработка регистрации
    public function register(Request $request)
    {
        $request->validate([
            'login' => 'required|string|max:255|unique:users',
            'password' => 'required|min:4|confirmed'
        ]);
        
        $userId = DB::table('users')->insertGetId([
            'login' => $request->login,
            'password' => Hash::make($request->password),
            'is_admin' => 0,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        Auth::loginUsingId($userId);
        
        return redirect()->route('profile');
    }
    
    // Показать форму входа
    public function showLogin()
    {
        return view('login');
    }
    
    // Обработка входа
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required',
            'password' => 'required'
        ]);
        
        $user = DB::table('users')->where('login', $request->login)->first();
        
        if ($user && Hash::check($request->password, $user->password)) {
            Auth::loginUsingId($user->id);
            
            if ($user->is_admin == 1) {
                return redirect()->route('admin');
            } else {
                return redirect()->route('profile');
            }
        }
        
        return back()->with('error', 'Неверный логин или пароль');
    }
    
    // Выход
    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }
    
    // Профиль
    public function profile()
    {
        $user = Auth::user();
        
        $favorites = DB::table('favorites')
            ->join('recipes', 'favorites.recipe_id', '=', 'recipes.id')
            ->where('favorites.user_id', $user->id)
            ->select('recipes.*')
            ->get();
        
        // Загружаем ингредиенты и шаги для каждого рецепта
        foreach ($favorites as $recipe) {
            $recipe->ingredients = DB::table('ingredient_recipe')
                ->join('ingredients', 'ingredient_recipe.ingredient_id', '=', 'ingredients.id')
                ->where('ingredient_recipe.recipe_id', $recipe->id)
                ->select('ingredients.name', 'ingredient_recipe.amount')
                ->get();
            $recipe->steps = json_decode($recipe->steps, true);
        }
        
        return view('profile', compact('user', 'favorites'));
    }
    
    // Админка
    public function admin()
    {
        if (Auth::user()->is_admin != 1) {
            return redirect()->route('home');
        }
        
        $users = DB::table('users')->get();
        $recipes = DB::table('recipes')->get();
        
        return view('admin', compact('users', 'recipes'));
    }

}