<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // ユーザーロールのENUMタイプを作成
        DB::statement("CREATE TYPE user_role AS ENUM ('super_admin', 'tenant_admin', 'user')");

        Schema::table('users', function (Blueprint $table) {
            // tenant_idカラムを追加
            $table->foreignId('tenant_id')->after('id')->nullable()->constrained()->onDelete('cascade');
            
            // ロールカラムを追加
            $table->enum('role', ['super_admin', 'tenant_admin', 'user'])->after('password')->default('user');
            
            // アクティブフラグを追加
            $table->boolean('is_active')->after('role')->default(true);
            
            // 最終ログイン日時を追加
            $table->timestamp('last_login_at')->after('is_active')->nullable();
            
            // 論理削除を追加
            $table->softDeletes();
            
            // インデックスを追加
            $table->index('tenant_id');
            $table->index('role');
            $table->index('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['tenant_id']);
            $table->dropColumn([
                'tenant_id',
                'role',
                'is_active',
                'last_login_at',
                'deleted_at'
            ]);
        });

        // ENUMタイプを削除
        DB::statement('DROP TYPE IF EXISTS user_role');
    }
};
