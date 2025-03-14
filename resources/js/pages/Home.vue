<template>
  <div class="bg-white">
    <!-- ヘッダー -->
    <header class="fixed top-0 left-0 right-0 z-50 bg-white shadow">
      <nav class="container mx-auto px-6 py-4">
        <div class="flex items-center justify-between">
          <div class="text-xl font-bold">AI SaaS</div>
          <div class="space-x-4">
            <router-link
              to="/login"
              class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >
              ログイン
            </router-link>
          </div>
        </div>
      </nav>
    </header>

    <!-- ヒーローセクション -->
    <div class="pt-20">
      <div class="container mx-auto px-6 py-16 text-center">
        <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl md:text-6xl">
          <span class="block">AIで最適化する</span>
          <span class="block text-indigo-600">Webサイト分析ツール</span>
        </h1>
        <p class="mt-3 max-w-md mx-auto text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
          AIがユーザーの行動を分析し、最適なCTAを提案。Webサイトのコンバージョン率を最大化します。
        </p>
        <div class="mt-10">
          <router-link
            to="/login"
            class="px-8 py-3 text-base font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
          >
            無料で始める
          </router-link>
        </div>
      </div>
    </div>

    <!-- 機能紹介セクション -->
    <div class="py-16 bg-gray-50">
      <div class="container mx-auto px-6">
        <div class="text-center">
          <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
            主な機能
          </h2>
        </div>
        <div class="mt-12 grid gap-8 grid-cols-1 md:grid-cols-3">
          <!-- 機能1 -->
          <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-medium text-gray-900">AIによる行動分析</h3>
            <p class="mt-2 text-gray-500">
              ユーザーの行動データをAIが分析し、最適な改善案を提案します。
            </p>
          </div>
          <!-- 機能2 -->
          <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-medium text-gray-900">簡単な導入</h3>
            <p class="mt-2 text-gray-500">
              タグを設置するだけで、すぐに分析を開始できます。
            </p>
          </div>
          <!-- 機能3 -->
          <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-medium text-gray-900">リアルタイム分析</h3>
            <p class="mt-2 text-gray-500">
              ユーザーの行動をリアルタイムで可視化し、即座に改善できます。
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- フッター -->
    <footer class="bg-gray-800">
      <div class="container mx-auto px-6 py-8">
        <div class="text-center text-gray-400">
          <p>&copy; 2024 AI SaaS. All rights reserved.</p>
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup lang="ts">
// 必要に応じてロジックを追加
</script> 