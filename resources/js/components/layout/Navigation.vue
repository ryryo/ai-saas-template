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
  await auth.logout();
  router.push({ name: 'login' });
};
</script>

<template>
  <nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
    <!-- トップバー -->
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
      <div class="flex items-center justify-between">
        <div class="flex items-center justify-start">
          <!-- サイドバートグル -->
          <button
            @click="toggleSidebar"
            class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
          >
            <span class="sr-only">サイドバーを開く</span>
            <div class="w-6 h-6 i-heroicons-bars-3" />
          </button>
          <!-- ロゴ -->
          <a href="/" class="flex ml-2 md:mr-24">
            <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white">
              AI-SaaS
            </span>
          </a>
        </div>
        <div class="flex items-center">
          <!-- プロフィールドロップダウン -->
          <div class="flex items-center ml-3">
            <div class="relative">
              <button
                type="button"
                class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                @click="handleLogout"
              >
                <span class="sr-only">ログアウト</span>
                <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <!-- サイドバー -->
  <aside
    :class="[
      'fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700',
      { '-translate-x-full': !isMobileMenuOpen },
      { 'sm:translate-x-0': !isSidebarCollapsed },
    ]"
  >
    <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
      <ul class="space-y-2 font-medium">
        <li v-for="item in navigation" :key="item.to" v-show="item.show">
          <router-link
            :to="item.to"
            :class="[
              'flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group',
              { 'bg-gray-100 dark:bg-gray-700': isCurrentRoute(item.to) },
            ]"
          >
            <div :class="['w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white', item.icon]" />
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