<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Atte</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/reset-password.css') }}" />
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
        <div class="reset_password_form">
            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address -->
                <div>
                    <x-label for="email" value="メールアドレス" />
                    <x-input id="email" class="email" type="email" name="email" :value="old('email', $request->email)"
                        required autofocus />
                </div>

                <!-- Password -->
                <div class="password">
                    <x-label for="password" value="新しいパスワード" />
                    <x-input id="password" class="password_button" type="password" name="password" required />
                </div>

                <!-- Confirm Password -->
                <div class="confirmation">
                    <x-label for="password_confirmation" :value="__('確認用')" />
                    <x-input id="password_confirmation" class="confirmation_button" type="password"
                        name="password_confirmation" required />
                </div>

                <div class="reset-button">
                    <x-button>
                        {{ 'パスワードリセット' }}
                    </x-button>
                </div>
            </form>
        </div>
    </main>
</body>
