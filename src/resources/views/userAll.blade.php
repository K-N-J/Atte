<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Atte</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/userAll.css') }}" />
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
                                    <a class="header__nav__link" href="/date">日付一覧</a>

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
            <a class="nav__btn" href="{{ route('userAll', ['date' => $prev_date]) }}">&lt;</a>
            <span>{{ $date }}</span>
            <a class="nav__btn" href="{{ route('userAll', ['date' => $next_date]) }}">&gt;</a>
        </div>
        <div class="date__form">
            <form method="GET" action="{{ route('userAll') }}">
                @csrf
                <div class="date__table">
                    <table class="date__list">
                        <tr>
                            <th>名前</th>
                        </tr>
                        @foreach ($attends as $attend)
                            <tr>
                                <td>
                                    <a class="header__nav__link"
                                        href="{{ route('userDetails', ['userId' => $attend->id]) }}">{{ $attend->name }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </form>
        </div>

        <div class="pagination">
            {{ $attends->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>

    </main>
    <footer class="footer">
        <a class="footer__logo">Atte,inc.</a>
    </footer>
</body>
