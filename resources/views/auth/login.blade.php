@extends('layouts.app')

@section('title', 'Вход')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-4">
            <h2>Вход</h2>
            <form method="POST" action="/login">
                @csrf
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Пароль</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button class="btn btn-primary">Войти</button>
            </form>
            <p class="mt-2">Нет аккаунта? <a href="/register">Регистрация</a></p>
        </div>
    </div>
@endsection