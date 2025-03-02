@extends('layouts.admin')

@section('css')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}" />
@endsection

@section('link')
@if (Auth::check())
<form class="form" action="/logout" method="post">
    @csrf
    <button class="header-nav__button">logout</button>
</form>
@endif
@endsection

@section('content')
<div class="section__title">
    <h2>Admin</h2>
</div>
<form class="search-form" action="/admin" method="get">
    <div class="search-form__item">
        <input class="search-form__item-input" type="text" name="keyword" placeholder="名前やメールアドレスを入力してください" />
        <select name="gender" class="search-form__item-select">
            <option value="">性別</option>
            <option value="1">男性</option>
            <option value="2">女性</option>
            <option value="3">その他</option>
        </select>
        <select name="category" class="search-form__item-select">
            @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
        <input class="search-form__item-select" type="date" />
    </div>
    <div class="search-form__button">
        <button class="search-form__button-submit" type="submit">検索</button>
        <button class="search-form__button-reset" type="reset">リセット</button>
    </div>
</form>
<div class="button-row">
    <button id="export-button">エクスポート</button>
    <div id="pagination">
        {{ $contacts->links() }}
    </div>
</div>

<table class="contact-table">
    <tr class="table-header">
        <th class="header-cell">名前</th>
        <th class="header-cell">性別</th>
        <th class="header-cell">メールアドレス</th>
        <th class="header-cell">お問い合わせの種類</th>
    </tr>
    @foreach($contacts as $contact)
    <tr>
        <td>{{ $contact->id }}</td>
        <td>{{ $contact->first_name }} {{ $contact->last_name }}</td>
        <td>{{ $contact->email }}</td>
        <td>{{ $contact->gender }}</td>
        <td>{{ $contact->category_id }}</td>
        <td>{{ $contact->detail }}</td>
        <td>{{ $contact->created_at }}</td>
        <td>
            <a href="#contactModal{{ $contact->id }}" class="open-modal">詳細</a>
        </td>
    </tr>

    <!-- モーダルウィンドウのHTML -->
    <div id="contactModal{{ $contact->id }}" class="modal">
        <div class="modal-content">
            <span class="close" data-modal-id="contactModal{{ $contact->id }}">&times;</span>
            <p><strong>名前:</strong> {{ $contact->first_name }} {{ $contact->last_name }}</p>
            <p><strong>性別:</strong> {{ $contact->gender }}</p>
            <p><strong>メールアドレス:</strong> {{ $contact->email }}</p>
            <p><strong>電話番号:</strong> {{ $contact->tel }}</p>
            <p><strong>住所:</strong> {{ $contact->address }}</p>
            <p><strong>建物名:</strong> {{ $contact->building }}</p>
            <p><strong>お問い合わせ種類:</strong> {{ $contact->category_id }}</p>
            <p><strong>お問い合わせ内容:</strong> {{ $contact->detail }}</p>
        </div>

        <!-- 削除ボタンとフォーム -->
        <form class="delete-form" action="/admin" method="post">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">削除</button>
            </form>
    </div>
    @endforeach

</table>
</div>