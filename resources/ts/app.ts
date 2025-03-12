import { createApp } from 'vue';
import { createPinia } from 'pinia';
import { createRouter, createWebHistory } from 'vue-router';
import App from './App.vue';
import Top from './pages/Top.vue';

// ルート定義
const routes = [
    {
        path: '/',
        name: 'top',
        component: Top
    }
];

// Vueルーターの作成
const router = createRouter({
    history: createWebHistory(),
    routes
});

// Piniaストアの作成
const pinia = createPinia();

// Vueアプリケーションの作成
const app = createApp(App);

// プラグインの使用
app.use(router);
app.use(pinia);

// アプリケーションのマウント
app.mount('#app'); 