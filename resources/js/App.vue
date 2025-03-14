<script setup lang="ts">
import { onMounted, computed } from 'vue';
import { useAuthStore } from '@/stores/auth';
import Navigation from '@/components/layout/Navigation.vue';
import { useRoute } from 'vue-router';

const auth = useAuthStore();
const route = useRoute();

// 初期認証状態の確認
onMounted(async () => {
  await auth.initAuth();
});

const showNavigation = computed(() => {
  return auth.isAuthenticated && !route.meta.hideNavigation;
});
</script>

<template>
  <div class="min-h-screen bg-background font-sans antialiased">
    <Navigation v-if="showNavigation" />
    
    <main :class="{ 'sm:ml-64 pt-16': showNavigation }">
      <div class="container mx-auto px-4 py-8">
        <router-view />
      </div>
    </main>
  </div>
</template> 