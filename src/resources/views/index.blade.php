@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('link')
<nav class="header-nav">
  <ul class="header-nav__list">
    @if (Auth::check())
    <li class="header-nav__item">
      <form action="/" method="get">
        @csrf
        <button class="header-nav__btn" type="submit">ホーム</button>
      </form>
    </li>
    <li class="header-nav__item">
      <form action="/attendance" method="post">
        @csrf
        <button class="header-nav__btn" type="submit">日付一覧</button>
      </form>
    </li>
    <li class="header-nav__item">
      <form action="/logout" method="post">
      @csrf
        <button class="header-nav__btn" type="submit">ログアウト</button>
      </form>
    </li>
    @endif
  </ul>
</nav>
@endsection

@section('content')
<div class="index__content">
  <h2 class="index__ttl">{{ Auth::user()->name }} さんお疲れ様です！</h2>
  <div class="attendance__panel">
    <form class="attendance__button" action="/attendance/start" method="post">
      @csrf
      <button class="attendance__button-submit" type="submit">勤務開始</button>
    </form>
    <form class="attendance__button" action="/attendance/end" method="post">
      @csrf
      <button class="attendance__button-submit" type="submit">勤務終了</button>
    </form>
    <form class="attendance__button" action="/break/start" method="post">
      @csrf
      <button class="attendance__button-submit" type="submit">休憩開始</button>
    </form>
    <form class="attendance__button" action="/break/end" method="post">
      @csrf
      <button class="attendance__button-submit" type="submit">休憩終了</button>
    </form>
  </div>
</div>
@endsection