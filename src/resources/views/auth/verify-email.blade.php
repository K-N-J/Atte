<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ 'ご登録いただきありがとうございます! 先ほどメールでお送りしたリンクをクリックし、メールアドレスをご確認下さい。 また、メールが届かない場合は、別のメールをお送りいたします。'}}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{'新しい確認リンクが、登録時に指定した電子メール アドレスに送信されました。'}}
            </div>
        @endif

        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div>
                    <x-button>
                        {{ '確認メールを再送'}}
                    </x-button>
                </div>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900">
                    {{'ログアウト' }}
                </button>
            </form>
        </div>
    </x-auth-card>
</x-guest-layout>
