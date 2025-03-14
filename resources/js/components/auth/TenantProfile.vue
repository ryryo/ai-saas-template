<script setup lang="ts">
import { useAuthStore } from '@/stores/auth';
import type { Tenant } from '@/types/auth';
import { computed } from 'vue';

const auth = useAuthStore();

const tenant = computed<Tenant | null>(() => auth.currentTenant);

const statusBadgeClass = computed(() => {
  switch (tenant.value?.status) {
    case 'active':
      return 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300';
    case 'inactive':
      return 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300';
    case 'suspended':
      return 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300';
    default:
      return 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300';
  }
});

const planBadgeClass = computed(() => {
  switch (tenant.value?.plan_type) {
    case 'premium':
      return 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300';
    case 'standard':
      return 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300';
    case 'free':
      return 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300';
    default:
      return 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300';
  }
});
</script>

<template>
  <div v-if="tenant" class="space-y-6">
    <div class="flex items-center space-x-4">
      <div class="h-12 w-12 rounded-full bg-primary/10 flex items-center justify-center">
        <span class="text-xl font-bold text-primary">
          {{ tenant.name.charAt(0).toUpperCase() }}
        </span>
      </div>
      <div>
        <h2 class="text-xl font-bold">{{ tenant.name }}</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">{{ tenant.email }}</p>
      </div>
    </div>

    <div class="grid gap-4 md:grid-cols-2">
      <div class="space-y-2">
        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">ステータス</p>
        <div class="flex items-center space-x-2">
          <span
            :class="[
              'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium',
              statusBadgeClass
            ]"
          >
            {{ tenant.status }}
          </span>
        </div>
      </div>

      <div class="space-y-2">
        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">プラン</p>
        <div class="flex items-center space-x-2">
          <span
            :class="[
              'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium',
              planBadgeClass
            ]"
          >
            {{ tenant.plan_type }}
          </span>
        </div>
      </div>

      <div class="space-y-2">
        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">ロール</p>
        <p class="text-sm">{{ tenant.role }}</p>
      </div>

      <div class="space-y-2">
        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">ドメイン</p>
        <p class="text-sm">{{ tenant.domain || '未設定' }}</p>
      </div>

      <div class="space-y-2">
        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">メール認証</p>
        <p class="text-sm">
          {{ tenant.email_verified_at ? '認証済み' : '未認証' }}
        </p>
      </div>

      <div class="space-y-2">
        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">最終ログイン</p>
        <p class="text-sm">
          {{ tenant.last_login_at || '記録なし' }}
        </p>
      </div>
    </div>

    <div class="pt-4 border-t">
      <button
        @click="auth.logout"
        class="inline-flex items-center justify-center rounded-md bg-destructive px-4 py-2 text-sm font-medium text-destructive-foreground hover:bg-destructive/90 focus:outline-none focus:ring-2 focus:ring-destructive focus:ring-offset-2 disabled:pointer-events-none disabled:opacity-50"
      >
        ログアウト
      </button>
    </div>
  </div>
</template> 