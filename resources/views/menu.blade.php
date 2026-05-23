@extends('layouts.app')

@section('title', 'Меню — Кофе и Книги')
@section('description', 'Меню кофейни Кофе и Книги — капучино, латте, раф, зелёный чай, круассаны и сэндвичи. Цены, фото, отзывы.')

@section('content')
    <h1>Меню</h1>

    <div class="row">
        <div class="col-md-3">
            <h4 style="color: var(--coffee-medium); margin-bottom: 20px;">Категории</h4>
            <div class="list-group mb-4">
                <a href="{{ route('menu') }}" class="list-group-item list-group-item-action {{ !$categoryId && !request('new') ? 'active' : '' }}">
                    Все
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('menu', ['category' => $cat->id]) }}" 
                       class="list-group-item list-group-item-action {{ $categoryId == $cat->id ? 'active' : '' }}">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>

            <h4 style="color: var(--coffee-medium); margin-bottom: 15px;">Фильтры</h4>
            <div class="list-group mb-4">
                <a href="{{ route('menu', request()->except('new') + ['new' => 1]) }}" 
                   class="list-group-item list-group-item-action {{ request('new') ? 'active' : '' }}">
                    Только новинки
                </a>
            </div>

            <h4 style="color: var(--coffee-medium); margin-bottom: 15px;">Сортировка</h4>
            <div class="list-group">
                <a href="{{ route('menu', request()->except('sort')) }}" 
                   class="list-group-item list-group-item-action {{ !request('sort') ? 'active' : '' }}">
                    По умолчанию
                </a>
                <a href="{{ route('menu', request()->except('sort') + ['sort' => 'price_asc']) }}" 
                   class="list-group-item list-group-item-action {{ request('sort') == 'price_asc' ? 'active' : '' }}">
                    Сначала дешёвые
                </a>
                <a href="{{ route('menu', request()->except('sort') + ['sort' => 'price_desc']) }}" 
                   class="list-group-item list-group-item-action {{ request('sort') == 'price_desc' ? 'active' : '' }}">
                    Сначала дорогие
                </a>
            </div>
        </div>

        <div class="col-md-9">
            <div class="row">
                @foreach($products as $product)
                    <div class="col-md-4 mb-4">
                        <a href="{{ route('product.show', $product->id) }}" style="text-decoration: none; color: inherit;">
                            <div class="card h-100">
                                @if($product->image)
                                    <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" loading="lazy" style="width: 100%; height: 200px; object-fit: cover; border-radius: 15px 15px 0 0;">
                                @else
                                    <div style="width: 100%; height: 200px; background: var(--beige); display: flex; align-items: center; justify-content: center; font-size: 3rem; border-radius: 15px 15px 0 0;">
                                        ☕
                                    </div>
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text" style="color: var(--coffee-medium); font-size: 0.9rem;">{{ $product->description }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="price">{{ $product->price }} руб.</span>
                                        @if($product->is_new)
                                            <span class="badge bg-success">Новинка</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <form action="{{ route('cart.add') }}" method="POST" onclick="event.stopPropagation();">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <button class="btn btn-sm btn-success w-100">В корзину</button>
                                    </form>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection