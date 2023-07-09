<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Atte</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/date.css') }}" />
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <div class="header__utilities">
                <a class="header__logo" href="/">
                    Atte
                </a>
                <div class="header__link">
                    <nav>
                        <ul class="header__nav">
                            <li class="header__nav__item">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a class="header__nav__link" href="/stamp">ホーム</a>
                                    <a class="header__nav__link" href="/user">ユーザー</a>

                                    <a class="header__nav__link" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                        ログアウト
                                    </a>
                                </form>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <main>
        <div class="nav__links">
            <a class="nav__btn" href="{{ route('date', ['date' => $prev_date]) }}">&lt;</a>
            <span>{{ $date }}</span>
            <a class="nav__btn" href="{{ route('date', ['date' => $next_date]) }}">&gt;</a>
        </div>
        <div class="date__form">
            <form method="GET" action="{{ route('date') }}">
                @csrf
                <div class="date__table">
                    <table class="date__list">
                        <tr>
                            <th>名前</th>
                            <th>勤務開始</th>
                            <th>勤務終了</th>
                            <th>休憩時間</th>
                            <th>勤務時間</th>
                        </tr>
                        @foreach ($attends as $attend)
                            <tr>
                                <td>
                                    {{ $attend->name }}
                                </td>
                                <td>
                                    {{ date('H:i', strtotime($attend->attend_start)) }}
                                </td>
                                <td>
                                    {{ $attend->attend_end ? date('H:i', strtotime($attend->attend_end)) : '' }}
                                </td>
                                <td>
                                    {{ $attend->rest_time ?? ($attend->work_time ? '00:00:00' : '') }}
                                </td>
                                <td>
                                    {{ $attend->work_time }}
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </form>
        </div>

        {{ $attends->appends(request()->query())->links('pagination::bootstrap-4') }}

    </main>
    <footer class="footer">
        <a class="footer__logo">Atte,inc.</a>
    </footer>
</body>
