<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Handle a login request to the application.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $tenant = Tenant::where('email', $request->email)->first();

        if (!$tenant || !Hash::check($request->password, $tenant->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // テナントが無効化されている場合はログインを拒否
        if ($tenant->status !== 'active') {
            throw ValidationException::withMessages([
                'email' => ['This account has been suspended.'],
            ]);
        }

        // 最終ログイン日時を更新
        $tenant->update(['last_login_at' => now()]);

        // トークンを生成（APIアクセス用）
        $token = $tenant->createToken('auth-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'tenant' => [
                'id' => $tenant->id,
                'name' => $tenant->name,
                'email' => $tenant->email,
                'role' => $tenant->role,
                'plan_type' => $tenant->plan_type,
                'status' => $tenant->status,
                'last_login_at' => $tenant->last_login_at,
            ],
        ]);
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request): JsonResponse
    {
        // 現在のトークンを削除
        if ($request->user()) {
            $request->user()->currentAccessToken()->delete();
        }

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Get the authenticated tenant.
     */
    public function me(Request $request): JsonResponse
    {
        $tenant = $request->user();

        return response()->json([
            'tenant' => [
                'id' => $tenant->id,
                'name' => $tenant->name,
                'email' => $tenant->email,
                'role' => $tenant->role,
                'plan_type' => $tenant->plan_type,
                'status' => $tenant->status,
                'last_login_at' => $tenant->last_login_at,
            ],
        ]);
    }
} 