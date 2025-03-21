<script setup lang="ts">
import { onMounted, computed, ref } from 'vue';
import { useAuthStore } from '@/stores/auth';
import Navigation from '@/components/layout/Navigation.vue';
import { useRoute, useRouter } from 'vue-router';

const auth = useAuthStore();
const route = useRoute();
const router = useRouter();
const isInitialized = ref(false);

// 初期認証状態の確認
onMounted(async () => {
  try {
    await auth.initAuth();
  } catch (error) {
    console.error('認証状態の初期化中にエラーが発生しました', error);
  } finally {
    isInitialized.value = true;
    
    // ログイン済みで、ゲスト用ページ（ログインなど）にアクセスした場合はダッシュボードへリダイレクト
    if (auth.isAuthenticated && route.meta.guest) {
      router.push('/dashboard');
    }
  }
});

const showNavigation = computed(() => {
  return auth.isAuthenticated && route.meta.requiresAuth;
});
</script>

<template>
  <div v-if="isInitialized" class="min-h-screen bg-background font-sans antialiased">
    <Navigation v-if="showNavigation" />
    
    <main :class="{ 'sm:ml-64 pt-16': showNavigation }">
      <div :class="{ 'container mx-auto px-4 py-8': showNavigation }">
        <router-view />
      </div>
    </main>
  </div>
  <div v-else class="min-h-screen flex items-center justify-center">
    <div class="text-center">
      <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-gray-900 mx-auto"></div>
      <p class="mt-2 text-gray-600">読み込み中...</p>
    </div>
  </div>
</template> 