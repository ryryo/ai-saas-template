<?php

use Illuminate\Support\Facades\Route;

// SPAのルーティング - すべてのルートをapp.blade.phpにルーティング
Route::get('/{any?}', function () {
    return view('app');
})->where('any', '.*');
