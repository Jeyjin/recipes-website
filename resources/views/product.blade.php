@extends('layouts.app')

@section('title', $product->name . ' — ' . $product->price . ' руб. — Кофе и Книги')
@section('description', $product->name . ' — ' . $product->description . ' Цена: ' . $product->price . ' руб. Категория: ' . $product->category->name)

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="background:transparent;" itemscope itemtype="https://schema.org/BreadcrumbList">
            <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <a href="{{ route('menu') }}" style="color: var(--coffee-medium); text-decoration: none;" itemprop="item">
                    <span itemprop="name">Меню</span>
                </a>
                <meta itemprop="position" content="1">
            </li>
            <li class="breadcrumb-item active" style="color: var(--pink-dark);" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <span itemprop="name">{{ $product->name }}</span>
                <meta itemprop="position" content="2">
            </li>
        </ol>
    </nav>

    <div class="row" itemscope itemtype="https://schema.org/Product">
        <div class="col-md-6 mb-4">
            @if($product->image)
                <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100%; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.1);" itemprop="image">
            @else
                <div style="width: 100%; height: 350px; background: var(--beige); border-radius: 20px; display: flex; align-items: center; justify-content: center; font-size: 6rem;">
                    ☕
                </div>
            @endif
        </div>
        <div class="col-md-6">
            <h1 style="border:none; margin-bottom: 15px;" itemprop="name">{{ $product->name }}</h1>
            
            <div class="d-flex align-items-center gap-2 mb-3">
                <span class="badge bg-success" style="font-size:0.9rem;" itemprop="category">{{ $product->category->name }}</span>
                @if($product->is_new)
                    <span class="badge bg-success" style="font-size:0.9rem;">Новинка</span>
                @endif
            </div>

            <p style="font-size:1.1rem; color: var(--coffee-medium); line-height: 1.8;" itemprop="description">{{ $product->description }}</p>
            
            <div itemprop="offers" itemscope itemtype="https://schema.org/Offer">
                <p style="font-size:2rem; color: var(--pink-dark); margin: 25px 0; font-weight: bold;" itemprop="price">{{ $product->price }} руб.</p>
                <meta itemprop="priceCurrency" content="RUB">
                <meta itemprop="availability" content="https://schema.org/InStock">
            </div>
            
            <form action="{{ route('cart.add') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <button class="btn btn-success btn-lg w-100">Добавить в корзину</button>
            </form>
            
            <a href="{{ route('menu') }}" class="btn btn-secondary w-100 mt-3">Назад в меню</a>
        </div>
    </div>
@endsection