@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin-register.css') }}" />
@endsection

@section('link')
<a class="header__link" href="/login">login</a>
@endsection

@section('content')
<div class="register__form">
    <h2 class="register-form__heading content__heading">Register</h2>
    <div class="register-form__inner">
        <form class="register-form__form" action="/register" method="post">
            @csrf
            <div class="register-form__group">
                <span class="form__label--item">お名前</span>
            </div>
            <div class="form__group-content">
                <label class="register-form__label" for="name">お名前</label>
                <input class="register-form__input" type="text" name="name" id="name" placeholder="例：山田 太郎" value="{{ old('name') }}">
                <p class=" register-form__error-message">
                    @error('name')
                    {{ $message }}
                    @enderror
                </p>
            </div>
            <div class="register-form__group">
                <label class="register-form__label" for="email">メールアドレス</label>
                <input class="register-form__input" type="mail" name="email" id="email" placeholder="例：test@example.com" value="{{ old('email') }}">
                <p class="register-form__error-message">
                    @error('email')
                    {{ $message }}
                    @enderror
                </p>
            </div>
            <div class="register-form__group">
                <label class="register-form__label" for="password">パスワード</label>
                <input class="register-form__input" type="password" name="password" id="password" placeholder="例：coachtech1106">
                <p class="register-form__error-message">
                    @error('password')
                    {{ $message }}
                    @enderror
                </p>
            </div>
            <input class="register-form__btn btn" type="submit" value="登録">
        </form>
    </div>
</div>
@endsection