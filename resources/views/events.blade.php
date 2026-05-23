@extends('layouts.app')

@section('description', 'Мероприятия в кофейне Кофе и Книги — книжный клуб по субботам, вечера поэзии, мастер-классы по кофе.')

@section('content')
    <h1>Мероприятия</h1>
    
    <div class="row">
        @foreach(\App\Models\Event::latest()->get() as $event)
            <div class="col-md-6 mb-4">
                <div class="info-block">
                    <h3 style="color: var(--coffee-dark);">{{ $event->title }}</h3>
                    <p style="color: var(--pink-dark); font-weight:bold;">{{ $event->date }}</p>
                    <p>{{ $event->description }}</p>
                </div>
            </div>
        @endforeach
    </div>
@endsection