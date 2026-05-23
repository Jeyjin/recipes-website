@extends('layouts.app')

@section('title', 'Настройки - Админка')

@section('content')
    <h1>Настройки</h1>

    <div class="row">
        <div class="col-md-5">
            <div class="info-block">
                <h4>Номер телефона для кнопки «Позвонить»</h4>
                <form action="{{ route('admin.settings.update') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Телефон</label>
                        <input type="text" name="phone" class="form-control" value="{{ $phone }}" required>
                    </div>
                    <button class="btn btn-success">Сохранить</button>
                </form>
            </div>
        </div>
    </div>
@endsection