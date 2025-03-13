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
        Schema::create('tracking_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
            $table->foreignId('tag_id')->constrained('tracking_tags')->onDelete('cascade');
            $table->string('event_type', 50);
            $table->string('page_url', 2048);
            $table->string('element_id', 255)->nullable();
            $table->string('element_class', 255)->nullable();
            $table->jsonb('user_agent')->nullable();
            $table->jsonb('event_data')->nullable();
            $table->string('client_ip', 45)->nullable();
            $table->timestamp('event_time')->useCurrent();
            $table->timestamp('created_at')->useCurrent();
        });

        // インデックスを追加
        Schema::table('tracking_events', function (Blueprint $table) {
            $table->index('tenant_id');
            $table->index('tag_id');
            $table->index('event_type');
            $table->index('event_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracking_events');
    }
};
