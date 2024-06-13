@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
@endsection

@section('link')
  <nav>
    <ul class="header-nav">
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
  <div class="attendance__content">
    <h2 class="date">
      {{ $formatteDate }}
    </h2>
    <div class="attendance-table">
      <table class="attendance-table__inner">
        <tr class="attendance-table__row">
          <th class="attendance-table__header">名前</th>
          <th class="attendance-table__header">勤務開始</th>
          <th class="attendance-table__header">勤務終了</th>
          <th class="attendance-table__header">休憩時間</th>
          <th class="attendance-table__header">勤務時間</th>
        </tr>
        @foreach ($attendances as $attendance)
        <tr class="attendance-table__row">
          <td class="attendance-table__item">
            {{ $attendance->user->name }}</td>
          <td class="attendance-table__item">
            {{ $attendance->start_time}}</td>
          <td class="attendance-table__item">
            {{ $attendance->end_time }}</td>
          <td class="attendance-table__item">
            {{ $attendance->rest_time }}</td>
          <td class="attendance-table__item">
            {{ $attendance->working_hours }}</td>
        </tr>
        @endforeach
      </table>
    </div>
  </div>
@endsection