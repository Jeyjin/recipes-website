@extends('layouts.app')

@section('description', 'История кофейни Кофе и Книги, наша миссия и команда. Открылись в 2020 году, рады каждому гостю.')

@section('content')
    <h1>О нас</h1>
    
    <div class="info-block mb-4">
        <h3>Наша история</h3>
        <p>Кофейня «Кофе и Книги» открыла свои двери в 2020 году. Идея родилась из любви к двум вещам: ароматному кофе и хорошим книгам. Мы хотели создать место, где можно выпить чашечку латте, листая любимый роман, или встретиться с друзьями за обсуждением прочитанного.</p>
        <p>Начинали мы с небольшого зала на десять столиков и скромного меню. Сегодня у нас уютное пространство с библиотекой, где каждый гость может взять книгу с полки и почитать за чашкой кофе.</p>
    </div>

    <div class="info-block mb-4">
        <h3>Наша миссия</h3>
        <p>Мы верим, что кофе и книги созданы друг для друга. Наша миссия — дарить гостям атмосферу уюта, тепла и вдохновения. Чтобы каждый, кто зашёл к нам, мог отдохнуть от городской суеты, насладиться вкусным напитком и найти время для себя.</p>
        <p>Мы используем только свежеобжаренные зёрна от локальных обжарщиков, а выпечку готовим каждое утро. Качество и душевность — вот что для нас главное.</p>
    </div>

    <h3 style="margin-top: 30px;">Наша команда</h3>
    <div class="row mt-3">
        <div class="col-md-4 mb-4">
            <div class="info-block text-center">
                <div style="width: 80px; height: 80px; background: var(--soft-pink); border-radius: 50%; margin: 0 auto 15px; display: flex; align-items: center; justify-content: center; font-size: 2rem; color: var(--coffee-dark);">
                    М
                </div>
                <h4>Михаил</h4>
                <p style="color: var(--pink-dark);">Шеф-бариста</p>
                <p>Знает о кофе всё. <br> Готовит идеальный капучино и всегда рад посоветовать что-то новое.</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="info-block text-center">
                <div style="width: 80px; height: 80px; background: var(--soft-pink); border-radius: 50%; margin: 0 auto 15px; display: flex; align-items: center; justify-content: center; font-size: 2rem; color: var(--coffee-dark);">
                    А
                </div>
                <h4>Анна</h4>
                <p style="color: var(--pink-dark);">Основатель</p>
                <p><br>Придумала идею кофейни, когда поняла,  что лучшие встречи с друзьями проходят за чашкой кофе и разговорами о книгах. </p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="info-block text-center">
                <div style="width: 80px; height: 80px; background: var(--soft-pink); border-radius: 50%; margin: 0 auto 15px; display: flex; align-items: center; justify-content: center; font-size: 2rem; color: var(--coffee-dark);">
                    Е
                </div>
                <h4>Елена</h4>
                <p style="color: var(--pink-dark);">Кондитер</p>
                <p>Каждое утро печёт свежие круассаны, готовит десерты и придумывает сезонное меню выпечки.</p>
            </div>
        </div>
    </div>


@endsection