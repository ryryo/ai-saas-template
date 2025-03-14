import { createApp } from 'vue';
import { createPinia } from 'pinia';
import App from './App.vue';
import router from './router';
import './bootstrap';

// アプリケーションの作成
const app = createApp(App);
const pinia = createPinia();

app.use(pinia);
app.use(router);

// アプリケーションのマウント
app.mount('#app'); 