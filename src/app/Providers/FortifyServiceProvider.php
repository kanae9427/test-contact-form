<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;


class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);

        Fortify::registerView(
            function () {
                return view('auth.admin-register');
            }
        );

        Fortify::loginView(
            function () {
                return view('auth.admin-login');
            }
        );

        Fortify::authenticateUsing(function (Request $request) {
            // バリデーションをリクエストクラスで処理
            $validated = app(\App\Http\Requests\LoginRequest::class)->validated();
            $user = \App\Models\User::where('email', $validated['email'])->first();

            if ($user && Hash::check($validated['password'], $user->password)) {
                return $user;
            }

            // ログイン失敗時に例外をスロー
            return null;
        });

        RateLimiter::for(
            'login',
            function (Request $request) {
                $email = (string) $request->email;

                return Limit::perMinute(10)->by($email . $request->ip());
            }
        );
    }
}
