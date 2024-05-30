@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('link')
<nav class="header-nav">
  <ul class="header-nav__list">
    <li class="header-nav__item">
      <a class="header-nav__link" href="/">ホーム</a>
    </li>
    <li class="header-nav__item">
      <a class="header-nav__link" href="/attendance">日付一覧</a>
    </li>
    <li class="header-nav__item">
      <a class="header-nav__link" href="/login">ログアウト</a>
    </li>
  </ul>
</nav>
@endsection

@section('content')
<div class="container">
  <h2 class="container__ttl">お疲れ様です！</h2>
  <form class="timestamp" action="">
    <button class="input-btn">勤務開始</button>
  </form>
  <form class="timestamp" action="">
    <button class="input-btn">勤務終了</button>
  </form>
  <form class="timestamp" action="">
    <button class="input-btn">休憩開始</button>
  </form>
  <form class="timestamp" action="">
    <button class="input-btn">休憩終了</button>
  </form>
</div>
@endsection