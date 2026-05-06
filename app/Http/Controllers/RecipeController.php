<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecipeController extends Controller
{
    public function index()
    {
        $ingredients = Ingredient::orderBy('name')->get();
        return view('index', compact('ingredients'));
    }
    
    public function search(Request $request)
    {
        $myIngredients = $request->input('ingredients', []);
        $mode = $request->input('mode', 'exact');
        
        if (empty($myIngredients)) {
            return response()->json(['recipes' => []]);
        }
        
        $recipes = Recipe::with('ingredients')->get();
        $result = [];
        
        foreach ($recipes as $recipe) {
            $recipeIngredients = $recipe->ingredients->pluck('name')->toArray();
            $intersection = array_intersect($myIngredients, $recipeIngredients);
            $missing = array_diff($recipeIngredients, $myIngredients);
            $matchPercent = count($intersection) / count($recipeIngredients) * 100;
            
            $include = false;
            if ($mode == 'exact' && count($missing) == 0) {
                $include = true;
            } elseif ($mode == 'partial' && $matchPercent >= 50) {
                $include = true;
            } elseif ($mode == 'all') {
                $include = true;
            }
            
            if ($include) {
                $result[] = [
                    'id' => $recipe->id,
                    'name' => $recipe->name,
                    'image' => $recipe->image,
                    'time' => $recipe->time,
                    'match_percent' => round($matchPercent),
                    'ingredients' => $recipe->ingredients->map(function($ing) use ($myIngredients) {
                        return [
                            'name' => $ing->name,
                            'amount' => $ing->pivot->amount,
                            'have' => in_array($ing->name, $myIngredients)
                        ];
                    }),
                    'missing_count' => count($missing),
                    'steps' => $recipe->steps
                ];
            }
        }
        
        usort($result, function($a, $b) {
            return $b['match_percent'] <=> $a['match_percent'];
        });
        
        return response()->json(['recipes' => $result]);
    }
    
    public function getFavoritesList()
    {
        if (!auth()->check()) {
            return response()->json([]);
        }
        
        $favorites = DB::table('favorites')
            ->where('user_id', auth()->id())
            ->pluck('recipe_id');
        
        return response()->json($favorites);
    }
    
    public function addToFavorites($id)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $exists = DB::table('favorites')
            ->where('user_id', auth()->id())
            ->where('recipe_id', $id)
            ->exists();
        
        if (!$exists) {
            DB::table('favorites')->insert([
                'user_id' => auth()->id(),
                'recipe_id' => $id,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        
        return response()->json(['success' => true]);
    }
    
    public function removeFromFavorites($id)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        DB::table('favorites')
            ->where('user_id', auth()->id())
            ->where('recipe_id', $id)
            ->delete();
        
        return response()->json(['success' => true]);
    }
}