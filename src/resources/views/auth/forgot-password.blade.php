<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Atte</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/forgot-password.css') }}" />
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
        <div class='forgot_password_form'>
            <div class="forgot_text">
                <p>パスワードをお忘れですか？<br />メールアドレスにパスワードリセットリンクを送信いたします。<br />そちらからリセットを行なって下さい。</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-label for="email" :value="__('Email')" />

                    <x-input id="email" class="email_input" type="email" name="email" :value="old('email')"
                        required autofocus />
                </div>

                <div class="password_reset_button">
                    <x-button>
                        {{'パスワードリセットメールを送信'}}
                    </x-button>
                </div>
            </form>
        </div>
    </main>
</body>
