@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="container">
  <div class="container__inner">
    <h2 class="container__ttl">
      ログイン
    </h2>
    <form class="form" action="">
      <div class="form__text">
        <input class="form__text--input" type="text" name="name" placeholder="名前">
      </div>
      <div class="form__text">
        <input class="form__text--input" type="text" name="email" placeholder="メールアドレス">
      </div>
      <div class="form__text">
        <input class="form__text--input" type="text" name="password" placeholder="パスワード">
      </div>
      <div class="form__text">
        <input class="form__text--input" type="text" name="password" placeholder="確認用パスワード">
      </div>
      <div class="form__text">
        <input class="form__text--input" type="text" name="password" placeholder="パスワード">
      </div>
      <div class="form__btn">
        <button class="form__btn-submit" type="submit">
          会員登録
        </button>
      </div>
    </form>
    <p class="message">
      アカウントをお持ちの方はこちらから
    </p>
    <a class="link" href="/login">
    ログイン
    </a>
  </div>
</div>
@endsection