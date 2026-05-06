<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $fillable = ['name', 'image', 'time', 'steps'];
    
    protected $casts = [
        'steps' => 'array'
    ];

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'ingredient_recipe', 'recipe_id', 'ingredient_id')->withPivot('amount');
    }
}