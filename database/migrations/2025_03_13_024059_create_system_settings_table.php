<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->jsonb('value')->default('{}');
            $table->text('description')->nullable();
            $table->boolean('is_tenant_configurable')->default(false);
            $table->timestamps();
        });

        // インデックスを追加
        Schema::table('system_settings', function (Blueprint $table) {
            $table->index('key');
            $table->index('is_tenant_configurable');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_settings');
    }
};
