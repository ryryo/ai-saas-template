import { createRouter, createWebHistory } from 'vue-router';
import { useAuthStore } from '@/stores/auth';

const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: '/',
      name: 'home',
      component: () => import('@/pages/Home.vue'),
      meta: { guest: true },
    },
    {
      path: '/login',
      name: 'login',
      component: () => import('@/components/auth/LoginForm.vue'),
      meta: { guest: true },
    },
    // {
    //   path: '/register',
    //   name: 'register',
    //   component: () => import('@/components/auth/RegisterForm.vue'),
    //   meta: { guest: true },
    // },
    {
      path: '/dashboard',
      name: 'dashboard',
      component: () => import('@/pages/Dashboard.vue'),
      meta: { requiresAuth: true },
    },
    // {
    //   path: '/settings',
    //   name: 'settings',
    //   component: () => import('@/pages/Settings.vue'),
    //   meta: { requiresAuth: true },
    // },
    // {
    //   path: '/tracking',
    //   name: 'tracking',
    //   component: () => import('@/pages/tracking/TagList.vue'),
    //   meta: { requiresAuth: true },
    // },
    // システム管理者用ルート
    // {
    //   path: '/admin',
    //   name: 'admin',
    //   component: () => import('@/pages/admin/AdminDashboard.vue'),
    //   meta: { requiresAuth: true, superAdmin: true },
    //   children: [
    //     {
    //       path: 'tenants',
    //       name: 'admin.tenants',
    //       component: () => import('@/pages/admin/TenantList.vue'),
    //     },
    //     {
    //       path: 'settings',
    //       name: 'admin.settings',
    //       component: () => import('@/pages/admin/SystemSettings.vue'),
    //     }
    //   ]
    // },
    // ルートが見つからない場合はホームにリダイレクト
    {
      path: '/:pathMatch(.*)*',
      redirect: { name: 'home' },
    },
  ],
});

// 認証ガード
router.beforeEach(async (to, from, next) => {
  const auth = useAuthStore();
  
  // 認証が必要なルートの場合
  if (to.matched.some((record) => record.meta.requiresAuth)) {
    if (!auth.isAuthenticated) {
      next({ name: 'login', query: { redirect: to.fullPath } });
    } else if (to.matched.some((record) => record.meta.superAdmin) && !auth.isSuperAdmin) {
      next({ name: 'dashboard' });
    } else {
      next();
    }
  } 
  // ゲスト用ルートの場合（ログイン・登録ページなど）
  else if (to.matched.some((record) => record.meta.guest)) {
    if (auth.isAuthenticated && to.name === 'login') {
      next({ name: 'dashboard' });
    } else {
      next();
    }
  } 
  // その他のルート
  else {
    next();
  }
});

export default router; 