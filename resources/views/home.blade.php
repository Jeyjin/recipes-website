@extends('layouts.app')

@section('title', 'Кофе и Книги — уютная кофейня')
@section('description', 'Кофейня Кофе и Книги — уютное место для чтения и кофе. Свежая выпечка, книжный клуб, вечера поэзии.')

@section('content')
    <section class="hero-section text-center" itemscope itemtype="https://schema.org/LocalBusiness">
        <h1 style="border:none; font-size:2.5rem;" itemprop="name">Добро пожаловать в кофейню</h1>
        <p style="font-size:1.8rem; color: var(--coffee-dark); margin-bottom: 10px;">Кофе и Книги</p>
        <p style="font-size:1.2rem; color: var(--coffee-medium);" itemprop="description">Уютное место для чтения и ароматного кофе</p>
        <meta itemprop="telephone" content="{{ \App\Helpers\SettingsHelper::getPhone() }}">
        <meta itemprop="address" content="ул. Примерная, д. 42">
        <a href="{{ route('menu') }}" class="btn btn-success" style="font-size:1.1rem; text-decoration:none;">Смотреть меню</a>
    </section>

    <section class="row mt-4">
        <article class="col-md-4 mb-4">
            <div class="info-block text-center">
                <h3>Новинки</h3>
                <p>Попробуйте наш новый Раф-кофе и сэндвич с курицей!</p>
                <a href="{{ route('menu') }}" class="btn btn-primary" style="text-decoration:none;">В меню</a>
            </div>
        </article>
        <article class="col-md-4 mb-4">
            <div class="info-block text-center">
                <h3>Мероприятия</h3>
                <p>Книжный клуб каждую субботу в 18:00. Вечер поэзии в последнюю пятницу месяца.</p>
                <a href="{{ route('events') }}" class="btn btn-primary" style="text-decoration:none;">Подробнее</a>
            </div>
        </article>
        <article class="col-md-4 mb-4">
            <div class="info-block text-center">
                <h3>Акция</h3>
                <p>Круассан + капучино всего за 300 рублей! Только в будние дни до 12:00.</p>
                <a href="{{ route('contacts') }}" class="btn btn-primary" style="text-decoration:none;">Контакты</a>
            </div>
        </article>
    </section>
@endsection