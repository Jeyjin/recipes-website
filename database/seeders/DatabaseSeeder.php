<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Админ
        User::create([
            'name' => 'Админ',
            'email' => 'admin@coffee.ru',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);

        // Обычный юзер
        User::create([
            'name' => 'Клиент',
            'email' => 'user@coffee.ru',
            'password' => bcrypt('password'),
            'is_admin' => false,
        ]);

        // Категории
        $coffee = Category::create(['name' => 'Кофе']);
        $tea = Category::create(['name' => 'Чай']);
        $food = Category::create(['name' => 'Еда']);

        // Товары
        Product::create([
            'name' => 'Капучино',
            'description' => 'Классический капучино с нежной пенкой',
            'price' => 200,
            'image' => 'products/cappuccino.jpg',
            'category_id' => $coffee->id,
            'is_new' => false,
        ]);

        Product::create([
            'name' => 'Латте',
            'description' => 'Кофе с большим количеством молока',
            'price' => 220,
            'image' => 'products/latte.jpg',
            'category_id' => $coffee->id,
            'is_new' => false,
        ]);

        Product::create([
            'name' => 'Раф',
            'description' => 'Нежный кофе со сливками и ванилью',
            'price' => 250,
            'image' => 'products/raf.jpg',
            'category_id' => $coffee->id,
            'is_new' => true,
        ]);

        Product::create([
            'name' => 'Зеленый чай',
            'description' => 'Китайский зеленый чай',
            'price' => 150,
            'image' => 'products/green-tea.jpg',
            'category_id' => $tea->id,
            'is_new' => false,
        ]);

        Product::create([
            'name' => 'Круассан',
            'description' => 'Свежий круассан с маслом',
            'price' => 180,
            'image' => 'products/croissant.jpg',
            'category_id' => $food->id,
            'is_new' => false,
        ]);
    }
}