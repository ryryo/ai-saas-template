<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// 認証不要のルート
Route::post('/auth', [LoginController::class, 'login'])->name('auth.login');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

// 認証が必要なルート
Route::middleware('auth:sanctum')->group(function () {
    // 認証関連
    Route::get('/auth/me', [LoginController::class, 'me'])->name('auth.me');
    Route::post('/auth/logout', [LoginController::class, 'logout'])->name('auth.logout');

    // テナント情報
    Route::get('/tenant', [LoginController::class, 'me'])->name('tenant.me');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // トラッキングタグ
    Route::apiResource('tracking-tags', TrackingTagController::class);

    // トラッキングイベント
    Route::apiResource('tracking-events', TrackingEventController::class)
        ->only(['index', 'show', 'store']);

    // テナント設定
    Route::get('/tenant/settings', [TenantSettingController::class, 'show'])
        ->name('tenant.settings.show');
    Route::patch('/tenant/settings', [TenantSettingController::class, 'update'])
        ->name('tenant.settings.update');
});

// システム管理者専用ルート
Route::middleware(['auth:sanctum', 'super_admin'])->group(function () {
    Route::apiResource('system-settings', SystemSettingController::class);
}); 