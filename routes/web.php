<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;
use App\Http\Controllers\PasswordResetController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;



Route::middleware('restrict.unverified')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/car/{car}', [CarController::class, 'show'])->whereNumber('car')->name('car.show');

    Route::middleware('guest')->group(function () {
        Route::get('/signup', [SignupController::class, 'create'])->name('signup');
        Route::post('/signup', [SignupController::class, 'store'])->name('signup.store');
        Route::get('/login', [LoginController::class, 'create'])->name('login');
        Route::post('/login', [LoginController::class, 'store'])->name('login.store');
        Route::get('/auth/{provider}/redirect', [SocialiteController::class, 'redirectToProvider'])
            ->whereIn('provider', ['google', 'facebook'])
            ->name('socialite.redirect');
        Route::get('/auth/{provider}/callback', [SocialiteController::class, 'handleProviderCallback'])
            ->whereIn('provider', ['google', 'facebook'])
            ->name('socialite.callback');

        Route::get('/forgot-password', [PasswordResetController::class, 'showForgotPassword'])->name('password.request');
        Route::post('/forgot-password', [PasswordResetController::class, 'forgotPassword'])->name('password.email');
        Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetPassword'])->name('password.reset');
        Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.update');
    });

    Route::middleware('auth')->group(function () {
        Route::get('/email/verify', function () {
            return view('auth.verify-email');
        })->name('verification.notice');

        Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
            $request->fulfill();

            return redirect()->route('home')->with('success', 'Email verified successfully!');
        })->middleware(['signed', 'throttle:6,1'])->name('verification.verify');

        Route::post('/email/verification-notification', function (Request $request) {
            $request->user()->sendEmailVerificationNotification();

            return back()->with('success', 'A new verification link has been sent to your email address.');
        })->middleware('throttle:6,1')->name('verification.send');

        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
        Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
    });

    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/about', function () {
            return view('about');
        });

        Route::get('/car/search', [CarController::class, 'search'])->name('car.search');
        Route::get('/car/watchlist', [CarController::class, 'watchlist'])->name('car.watchlist');
        Route::post('/car/{car}/watchlist', [CarController::class, 'storeWatchlist'])->name('car.watchlist.store');
        Route::delete('/car/{car}/watchlist', [CarController::class, 'destroyWatchlist'])->name('car.watchlist.destroy');
        Route::resource('car', CarController::class)->except(['show']);
        Route::get('/car/{car}/images', [CarController::class, 'carImages'])->name('car.images');
        Route::put('/car/{car}/images', [CarController::class, 'updateImages'])->name('car.updateImages');
    });
});
