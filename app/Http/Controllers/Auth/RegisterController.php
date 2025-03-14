<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\TenantSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    /**
     * Handle a registration request for the application.
     */
    public function register(Request $request): JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:tenants'],
            'password' => ['required', 'string', Password::defaults()],
            'domain' => ['nullable', 'string', 'max:255', 'unique:tenants'],
        ]);

        try {
            DB::beginTransaction();

            // テナントの作成
            $tenant = Tenant::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'domain' => $request->domain,
                'role' => 'tenant_admin',
                'plan_type' => 'free',
                'status' => 'active',
            ]);

            // テナント設定の作成
            TenantSetting::create([
                'tenant_id' => $tenant->id,
                'theme' => 'light',
                'notification_preferences' => [
                    'email' => true,
                    'web' => true,
                ],
            ]);

            DB::commit();

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
                ],
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
} 