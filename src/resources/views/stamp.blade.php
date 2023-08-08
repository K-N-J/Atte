<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Atte</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/stamp.css') }}" />
</head>

<body>

    <header class="header">
        <div class="header__inner">
            <div class="header__utilities">
                <a class="header__logo" href="/">
                    Atte
                </a>
                <nav>
                    <ul class="header__nav">
                        <li class="header__nav__item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a class="header__nav__link" href="/stamp">ホーム</a>
                                <a class="header__nav__link" href="/userAll">ユーザー一覧</a>
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
    </header>

    <main>
        @if (session('success'))
            <div class="success-message">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="error-message">{{ session('error') }}</div>
        @endif


        <div class="stamp__form">
            <div class="stamp__grid__parent">
                <div class="space1"></div>
                <div class="space2"></div>
                <div class="space3"></div>

                <div class="goodwork">
                    <p class="goodwork__text">{{ auth()->user()->name }}さんお疲れ様です！
                    </p>
                </div>

                <div class="attendstart">
                    <form method="POST" action="{{ route('attend-start') }}">
                        @csrf
                        <button type="submit" class="attendstart__button" id="attend-button">
                            <span class="attendstart__button__text">{{ '勤務開始' }}</span>
                        </button>
                    </form>
                </div>

                <div class="attendend">
                    <form method="POST" action="{{ route('attend-end') }}">
                        @csrf
                        <button type="submit" class="attendend__button" id="attend-end-button">
                            <span class="attendend__button__text">{{ '勤務終了' }}</span>
                        </button>
                    </form>
                </div>

                <div class="reststart">
                    <form method="POST" action="{{ route('rest-start') }}">
                        @csrf
                        <button type="submit" class="reststart__button">
                            <span class="reststart__button__text">{{ '休憩開始' }}</span>
                        </button>
                    </form>
                </div>

                <div class="restend">
                    <form method="POST" action="{{ route('rest-end') }}">
                        @csrf
                        <button type="submit" class="restend__button">
                            <span class="restend__button__text">{{ '休憩終了' }}</span>
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </main>
    <footer class="footer">
        <a class="footer__logo">Atte,inc.</a>
    </footer>
</body>
