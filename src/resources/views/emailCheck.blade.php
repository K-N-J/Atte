<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Atte</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/emailCheck.css') }}" />
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <div class="header__utilities">
                <a class="header__logo" href="/">
                    Atte
                </a>
            </div>
        </div>
    </header>
<main>
<div class="thanks__form">
        <div class="thanks__text">
            <h3>ご登録ありがとうございます。<br/>
                メールを送信しました。送信されたメールからログイン画面に行き、<br/>ログインを行なって下さい。</h3>
        </div>
        <div class="thanks__button">
            <a href="{{ route('login') }}" class="form__button">ログインページへ</a>
        </div>
    </div>
</main>

</body>