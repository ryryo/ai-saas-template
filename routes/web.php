<?php

use Illuminate\Support\Facades\Route;

// ログインページ - ゲストのみアクセス可能
Route::middleware(['web', 'guest'])->group(function () {
    Route::get('/login', function () {
        return view('app');
    })->name('login');
    
    Route::get('/register', function () {
        return view('app');
    })->name('register');
});

// 認証が必要なルート
Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('app');
    })->name('dashboard');
});

// その他すべてのルートをSPAにルーティング
Route::get('/{any?}', function () {
    return view('app');
})->where('any', '^(?!api).*$');
