@extends('layouts.app')

@section('title', 'Регистрация')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-4">
            <h2>Регистрация</h2>
            <form method="POST" action="/register">
                @csrf
                <div class="mb-3">
                    <label>Имя</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Пароль</label>
                    <input type="password" name="password" class="form-control" required minlength="6">
                </div>
                <button class="btn btn-primary">Зарегистрироваться</button>
            </form>
            <p class="mt-2">Уже есть аккаунт? <a href="/login">Войти</a></p>
        </div>
    </div>
@endsection