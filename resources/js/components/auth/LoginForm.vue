<script setup lang="ts">
import { ref } from 'vue';
import { useAuthStore } from '@/stores/auth';
import type { LoginCredentials } from '@/types/auth';
import { useRouter } from 'vue-router';

const auth = useAuthStore();
const router = useRouter();

const credentials = ref<LoginCredentials>({
  email: '',
  password: '',
  remember: false,
});

const isSubmitting = ref(false);
const errorMessage = ref<string | null>(null);

const handleSubmit = async () => {
  if (isSubmitting.value) return;

  isSubmitting.value = true;
  errorMessage.value = null;

  try {
    await auth.login(credentials.value);
    router.push('/dashboard');
  } catch (error: any) {
    errorMessage.value = error.response?.data?.message || 'ログインに失敗しました';
  } finally {
    isSubmitting.value = false;
  }
};
</script>

<template>
  <div class="w-full max-w-md space-y-6 p-6 bg-white rounded-lg shadow-md dark:bg-gray-800">
    <div class="space-y-2 text-center">
      <h1 class="text-2xl font-bold tracking-tight">
        ログイン
      </h1>
      <p class="text-sm text-gray-500 dark:text-gray-400">
        アカウントにログインしてください
      </p>
    </div>

    <form @submit.prevent="handleSubmit" class="space-y-4">
      <div class="space-y-2">
        <label
          for="email"
          class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
        >
          メールアドレス
        </label>
        <input
          id="email"
          v-model="credentials.email"
          type="email"
          required
          placeholder="mail@example.com"
          class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
        />
      </div>

      <div class="space-y-2">
        <label
          for="password"
          class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
        >
          パスワード
        </label>
        <input
          id="password"
          v-model="credentials.password"
          type="password"
          required
          class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
        />
      </div>

      <div class="flex items-center space-x-2">
        <input
          id="remember"
          v-model="credentials.remember"
          type="checkbox"
          class="h-4 w-4 rounded border-gray-300 text-primary focus:ring-primary"
        />
        <label
          for="remember"
          class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
        >
          ログイン状態を保持
        </label>
      </div>

      <div v-if="errorMessage" class="text-sm text-red-500 dark:text-red-400">
        {{ errorMessage }}
      </div>

      <button
        type="submit"
        :disabled="isSubmitting"
        class="inline-flex w-full items-center justify-center rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 dark:bg-primary dark:text-primary-foreground dark:hover:bg-primary/90 dark:focus:ring-primary"
      >
        <span v-if="isSubmitting">ログイン中...</span>
        <span v-else>ログイン</span>
      </button>
    </form>

    <div class="text-center text-sm">
      <router-link
        to="/forgot-password"
        class="text-sm text-primary underline-offset-4 hover:underline"
      >
        パスワードをお忘れですか？
      </router-link>
    </div>

    <div class="relative">
      <div class="absolute inset-0 flex items-center">
        <span class="w-full border-t" />
      </div>
      <div class="relative flex justify-center text-xs uppercase">
        <span class="bg-background px-2 text-muted-foreground">
          または
        </span>
      </div>
    </div>

    <div class="text-center text-sm">
      <router-link
        to="/register"
        class="text-sm text-primary underline-offset-4 hover:underline"
      >
        新規登録はこちら
      </router-link>
    </div>
  </div>
</template> 