<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;


class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $error=null;
        return view('auth.login')->with('error', null);
    }

    public function stamp()
    {
        return view('stamp');
    }

    public function thanks()
    {
        return view('thanks');
    }

    public function emailCheck()
    {
        return view('emailCheck');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function store(LoginRequest $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        // ログインを試みる前にメールアドレスが認証済みか確認する
        $user = Auth::attempt($credentials) && $request->user()->hasVerifiedEmail();

        if ($user) {
            $request->session()->regenerate();

            $error = null;
            return view('/stamp', compact('error'));
            //return redirect()->intended(RouteServiceProvider::HOME);
        }

        $request->session()->put('is_logged_in', true);

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }


    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $request->session()->forget('is_logged_in');

        return redirect('/thanks');
    }
}
