<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // Главная админки
    public function index()
    {
        $usersCount = DB::table('users')->count();
        $recipesCount = DB::table('recipes')->count();
        $favoritesCount = DB::table('favorites')->count();
        
        return view('admin.index', compact('usersCount', 'recipesCount', 'favoritesCount'));
    }
    
    // Управление пользователями
    public function users()
    {
        $users = DB::table('users')->orderBy('id')->get();
        return view('admin.users', compact('users'));
    }
    
    // Смена роли пользователя
    public function changeRole(Request $request, $id)
    {
        DB::table('users')->where('id', $id)->update([
            'is_admin' => $request->is_admin,
            'updated_at' => now()
        ]);
        
        return response()->json(['success' => true]);
    }
    
    // Удаление пользователя
    public function deleteUser($id)
    {
        if ($id == auth()->id()) {
            return response()->json(['error' => 'Нельзя удалить себя'], 400);
        }
        
        DB::table('favorites')->where('user_id', $id)->delete();
        DB::table('users')->where('id', $id)->delete();
        
        return response()->json(['success' => true]);
    }
    
    // Список рецептов
    public function recipes()
    {
        $recipes = DB::table('recipes')->orderBy('id')->get();
        foreach ($recipes as $recipe) {
            $recipe->ingredients = DB::table('ingredient_recipe')
                ->join('ingredients', 'ingredient_recipe.ingredient_id', '=', 'ingredients.id')
                ->where('ingredient_recipe.recipe_id', $recipe->id)
                ->select('ingredients.id', 'ingredients.name', 'ingredient_recipe.amount')
                ->get();
        }
        
        return view('admin.recipes', compact('recipes'));
    }
    
    // Форма создания рецепта
    public function createRecipe()
    {
        $ingredients = DB::table('ingredients')->orderBy('name')->get();
        return view('admin.recipe-form', compact('ingredients'));
    }
    
    // Сохранение рецепта
    public function storeRecipe(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'time' => 'required|integer|min:1',
            'steps' => 'required|array|min:1',
            'ingredients' => 'required|array|min:1',
        ]);
        
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $filename);
            $imagePath = '/images/' . $filename;
        }
        
        $recipeId = DB::table('recipes')->insertGetId([
            'name' => $request->name,
            'image' => $imagePath,
            'time' => $request->time,
            'steps' => json_encode($request->steps, JSON_UNESCAPED_UNICODE),
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        foreach ($request->ingredients as $ingredientId) {
            DB::table('ingredient_recipe')->insert([
                'recipe_id' => $recipeId,
                'ingredient_id' => $ingredientId,
                'amount' => $request->amounts[$ingredientId] ?? 'по вкусу',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        
        return redirect()->route('admin.recipes')->with('success', 'Рецепт создан');
    }
    
    // Форма редактирования рецепта
    public function editRecipe($id)
    {
        $recipe = DB::table('recipes')->where('id', $id)->first();
        $recipe->steps = json_decode($recipe->steps);
        $recipe->ingredients = DB::table('ingredient_recipe')
            ->where('recipe_id', $id)
            ->pluck('ingredient_id')
            ->toArray();
        
        $ingredients = DB::table('ingredients')->orderBy('name')->get();
        
        return view('admin.recipe-form', compact('recipe', 'ingredients'));
    }
    
    // Обновление рецепта
    public function updateRecipe(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'time' => 'required|integer|min:1',
            'steps' => 'required|array|min:1',
            'ingredients' => 'required|array|min:1',
        ]);
        
        $updateData = [
            'name' => $request->name,
            'time' => $request->time,
            'steps' => json_encode($request->steps, JSON_UNESCAPED_UNICODE),
            'updated_at' => now()
        ];
        
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $filename);
            $updateData['image'] = '/images/' . $filename;
        }
        
        DB::table('recipes')->where('id', $id)->update($updateData);
        
        DB::table('ingredient_recipe')->where('recipe_id', $id)->delete();
        
        foreach ($request->ingredients as $ingredientId) {
            DB::table('ingredient_recipe')->insert([
                'recipe_id' => $id,
                'ingredient_id' => $ingredientId,
                'amount' => $request->amounts[$ingredientId] ?? 'по вкусу',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        
        return redirect()->route('admin.recipes')->with('success', 'Рецепт обновлён');
    }
    
    // Удаление рецепта
    public function deleteRecipe($id)
    {
        DB::table('ingredient_recipe')->where('recipe_id', $id)->delete();
        DB::table('favorites')->where('recipe_id', $id)->delete();
        DB::table('recipes')->where('id', $id)->delete();
        
        return response()->json(['success' => true]);
    }
    
    // Загрузка картинки через Drag & Drop
    public function uploadImage(Request $request, $id)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);
        
        $image = $request->file('image');
        $filename = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('images'), $filename);
        
        DB::table('recipes')->where('id', $id)->update([
            'image' => '/images/' . $filename,
            'updated_at' => now()
        ]);
        
        return response()->json(['success' => true, 'path' => '/images/' . $filename]);
    }
}