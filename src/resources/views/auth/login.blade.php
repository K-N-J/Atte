<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Atte</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/login.css') }}" />
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <a class="header__logo" href="/">
                Atte
            </a>
        </div>
    </header>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors" />

    <main>
        <div class="login__form">

            <div class="login__title">
                <h2>ログイン</h2>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <!-- Email Address -->
                <div class="login__email">
                    <input id="email" class="input__email" type="email" name="email" placeholder="メールアドレス"
                        :value="old('email')" required autofocus />
                </div>

                <!-- Password -->
                <div class="login__password">
                    <input id="password" class="input__password" type="password" name="password" placeholder="パスワード"
                        required autocomplete="current-password" />
                </div>

                <button class="login__button">
                    <span class="login__button__text">
                        {{ 'ログイン' }}
                    </span>
                </button>

                <!-- Remember Me -->
                <div class="remember__me__form">
                    <label for="remember_me" class="remember__me__label">
                        <input id="remember_me" type="checkbox" class="input__remember__me" name="remember">
                        <span class="remember__me__text">
                            {{ 'ログイン状態を維持' }}
                        </span>
                    </label>
                </div>

                <div class="password__request">
                    @if (Route::has('password.request'))
                        <a class="forgot__password__text" href="{{ route('password.email') }}">
                            {{ 'パスワードのお忘れはこちらへ' }}
                        </a>
                    @endif
                </div>
                <div class="account__register">
                    <span class="subtext">アカウントをお持ちでない方はこちらから</span><br />
                    @if (Route::has('password.request'))
                        <a class="forgot__password__text" href="{{ route('register') }}">
                            {{ '会員登録' }}
                        </a>
                    @endif
                </div>

            </form>
        </div>
    </main>
</body>
