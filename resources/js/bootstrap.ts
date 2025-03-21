import axios from 'axios';
import type { AxiosError } from 'axios';

// CSRFトークンの設定
const token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = (token as HTMLMetaElement).content;
} else {
    console.error('CSRF token not found');
}

// Axiosのデフォルト設定
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.withCredentials = true;

// 保存されているトークンがあれば設定
const savedToken = localStorage.getItem('token');
if (savedToken) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${savedToken}`;
}

// エラーハンドリング
axios.interceptors.response.use(
    response => response,
    (error: AxiosError) => {
        if (error.response?.status === 401) {
            // 認証エラーの場合、ローカルストレージをクリアしてログインページにリダイレクト
            localStorage.removeItem('token');
            delete axios.defaults.headers.common['Authorization'];
        }
        return Promise.reject(error);
    }
); 