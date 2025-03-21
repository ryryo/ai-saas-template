<?php

namespace Tests\Feature\Auth;

use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    private function createSuperAdmin()
    {
        return Tenant::create([
            'name' => 'スーパー管理者',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'plan_type' => 'premium',
            'status' => 'active',
        ]);
    }

    private function createDemoTenant()
    {
        return Tenant::create([
            'name' => 'デモテナント',
            'email' => 'demo@example.com',
            'password' => Hash::make('password'),
            'role' => 'tenant_admin',
            'plan_type' => 'free',
            'status' => 'active',
        ]);
    }

    public function test_super_admin_can_authenticate(): void
    {
        $admin = $this->createSuperAdmin();

        $response = $this->postJson('/api/auth/login', [
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'token',
                'tenant' => [
                    'id',
                    'name',
                    'email',
                    'role',
                    'plan_type',
                    'status',
                    'created_at',
                    'updated_at',
                ],
            ])
            ->assertJson([
                'tenant' => [
                    'role' => 'super_admin',
                    'plan_type' => 'premium',
                    'status' => 'active',
                ],
            ]);
    }

    public function test_demo_tenant_can_authenticate(): void
    {
        $demo = $this->createDemoTenant();

        $response = $this->postJson('/api/auth/login', [
            'email' => 'demo@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'token',
                'tenant' => [
                    'id',
                    'name',
                    'email',
                    'role',
                    'plan_type',
                    'status',
                    'created_at',
                    'updated_at',
                ],
            ])
            ->assertJson([
                'tenant' => [
                    'role' => 'tenant_admin',
                    'plan_type' => 'free',
                    'status' => 'active',
                ],
            ]);
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $tenant = Tenant::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'token',
                'tenant' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                ],
            ]);
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $tenant = Tenant::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email' => 'test@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    public function test_authenticated_user_can_logout(): void
    {
        $tenant = Tenant::factory()->create();
        $token = $tenant->createToken('auth-token')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/auth/logout');

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'ログアウトしました。'
            ]);

        $this->assertDatabaseCount('personal_access_tokens', 0);
    }

    public function test_authenticated_user_can_get_their_information(): void
    {
        $tenant = Tenant::factory()->create();
        $token = $tenant->createToken('auth-token')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/auth/me');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                ],
            ]);
    }

    public function test_unauthenticated_user_cannot_access_protected_routes(): void
    {
        $response = $this->getJson('/api/auth/me');

        $response->assertStatus(401);
    }
} 