@extends('layouts.app')

@section('description', 'Контакты кофейни Кофе и Книги — адрес, телефон, режим работы. Ждём вас ежедневно с 8:00 до 23:00.')

@section('content')
    <h1>Контакты</h1>
    <p>Адрес: ул. Пушкина, д. 67</p>
    <p>Телефон: +7 (950) 123-45-67</p>
    <p>Режим работы: Пн-Пт 8:00–22:00, Сб-Вс 9:00–23:00</p>
    <p>Email: HelloWorld@coffee-books.ru</p>

    <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3Af44389214795bbfc2400aeaa42cfa56117f45eb4cd3cf70d03bfcd8df9b6a9ae&amp;width=500&amp;height=400&amp;lang=ru_RU&amp;scroll=true"></script>
@endsection