<?php

use Illuminate\Support\Facades\Route;

// APIルート以外のすべてのルートをVueアプリケーションにルーティング
Route::get('/{any?}', function () {
    return view('app');
})->where('any', '.*');
