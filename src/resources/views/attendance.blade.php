@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
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
  <div class="container">
    <h2 class="date">2024-05-29</h2>
    <div class="attendance-table">
      <table class="attendance-table__inner">
        <tr class="attendance-table__row">
          <th class="attendance-table__header">名前</th>
          <th class="attendance-table__header">勤務開始</th>
          <th class="attendance-table__header">勤務終了</th>
          <th class="attendance-table__header">休憩時間</th>
          <th class="attendance-table__header">勤務時間</th>
        </tr>
        <tr class="attendance-table__row">
          <td class="attendance-table__text">名前</td>
          <td class="attendance-table__text">0:00:00</td>
          <td class="attendance-table__text">0:00:00</td>
          <td class="attendance-table__text">0:00:00</td>
          <td class="attendance-table__text">0:00:00</td>
        </tr>
      </table>
    </div>
  </div>
@section('content')
@endsection