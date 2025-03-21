<script setup lang="ts">
import { ref, computed } from 'vue';
import { useAuthStore } from '@/stores/auth';
import { useRoute, useRouter } from 'vue-router';

const router = useRouter();
const auth = useAuthStore();
const route = useRoute();

const isMobileMenuOpen = ref(false);
const isSidebarCollapsed = ref(false);

const tenant = computed(() => auth.currentTenant);
const isSuperAdmin = computed(() => auth.isSuperAdmin);

const navigation = computed(() => [
  {
    name: 'ダッシュボード',
    to: '/dashboard',
    icon: 'i-heroicons-home',
    show: true,
  },
  {
    name: 'テナント管理',
    to: '/tenants',
    icon: 'i-heroicons-building-office',
    show: isSuperAdmin.value,
  },
  {
    name: 'トラッキングタグ',
    to: '/tracking-tags',
    icon: 'i-heroicons-tag',
    show: true,
  },
  {
    name: 'イベント分析',
    to: '/events',
    icon: 'i-heroicons-chart-bar',
    show: true,
  },
  {
    name: 'AI提案',
    to: '/ai-suggestions',
    icon: 'i-heroicons-light-bulb',
    show: true,
  },
  {
    name: '設定',
    to: '/settings',
    icon: 'i-heroicons-cog-6-tooth',
    show: true,
  },
]);

const toggleMobileMenu = () => {
  isMobileMenuOpen.value = !isMobileMenuOpen.value;
};

const toggleSidebar = () => {
  isSidebarCollapsed.value = !isSidebarCollapsed.value;
};

const isCurrentRoute = (path: string) => {
  return route.path === path;
};

const handleLogout = async () => {
  try {
    await auth.logout();
    // ログアウト後は常にログインページに遷移
    router.push({ name: 'login' });
  } catch (error) {
    console.error('ログアウト中にエラーが発生しました:', error);
    // エラーが発生しても状態をクリアしてログインページに遷移
    router.push({ name: 'login' });
  }
};
</script>

<template>
  <nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
      <div class="flex items-center justify-between">
        <div class="flex items-center justify-start">
          <button
            @click="toggleSidebar"
            class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200"
          >
            <span class="sr-only">メニューを開く</span>
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
              <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
            </svg>
          </button>
          <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap">AI SaaS</span>
        </div>
        <div class="flex items-center">
          <button
            @click="handleLogout"
            class="text-gray-500 hover:text-gray-700 hover:bg-gray-100 px-4 py-2 text-sm rounded-md transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-gray-200"
          >
            ログアウト
          </button>
        </div>
      </div>
    </div>
  </nav>

  <aside
    :class="['fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform bg-white border-r border-gray-200 sm:translate-x-0', { '-translate-x-full': !isSidebarCollapsed }]"
  >
    <div class="h-full px-3 pb-4 overflow-y-auto bg-white">
      <ul class="space-y-2 font-medium">
        <li v-for="item in navigation" :key="item.to" v-show="item.show">
          <router-link
            :to="item.to"
            :class="[
              'flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100',
              { 'bg-gray-100': isCurrentRoute(item.to) }
            ]"
          >
            <span :class="[item.icon, 'w-6 h-6']"></span>
            <span class="ml-3">{{ item.name }}</span>
          </router-link>
        </li>
      </ul>
    </div>
  </aside>

  <!-- モバイルメニュー -->
  <div
    v-show="isMobileMenuOpen"
    class="fixed inset-0 z-30 bg-gray-900 bg-opacity-50 dark:bg-opacity-80 sm:hidden"
    @click="toggleMobileMenu"
  />
</template> 