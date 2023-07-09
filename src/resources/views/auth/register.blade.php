<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Atte</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/register.css') }}" />
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <a class="header__logo" href="/">
                Atte
            </a>
        </div>
    </header>

    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors" />

    <main>
        <div class="register__form">
            <div class="register__title">
                <h2>会員登録</h2>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="name__form">
                    <input class="input__register" id="name" type="text" name="name" placeholder="名前"
                        :value="old('name')" required autofocus />
                </div>

                <!-- Email Address -->
                <div class="email__form">
                    <input id="email" class="input__email" type="email" name="email" placeholder="メールアドレス"
                        :value="old('email')" required />
                </div>

                <!-- Password -->
                <div class="password__form">
                    <input id="password" class="input__password" type="password" name="password" placeholder="パスワード"
                        required autocomplete="new-password" />
                </div>

                <!-- Confirm Password -->
                <div class="confirm__password__form">
                    <input id="password_confirmation" class="input__confirm__password" type="password"
                        name="password_confirmation" placeholder="確認用パスワード" required />
                </div>

                <button class="register__button">
                    <span class="register__button__text">{{ '会員登録' }}</span>
                </button>

                <div class="already__register__form">
                    <span class="subtext">アカウントをお持ちの方はこちらから</span><br />
                    <a class="already__register__text" href="{{ route('login') }}">
                        {{ 'ログイン' }}
                    </a>
                </div>
            </form>
        </div>
    </main>
</body>
