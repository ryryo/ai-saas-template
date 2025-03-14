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
    {
      path: '/dashboard',
      name: 'dashboard',
      component: () => import('@/pages/Dashboard.vue'),
      meta: { requiresAuth: true },
    },
    /*
    {
      path: '/tracking-tags',
      name: 'tracking-tags',
      component: () => import('@/pages/tracking/TagList.vue'),
      meta: { requiresAuth: true },
    },
    {
      path: '/settings',
      name: 'settings',
      component: () => import('@/pages/Settings.vue'),
      meta: { requiresAuth: true },
    },
    {
      path: '/tenants',
      name: 'tenants',
      component: () => import('@/pages/tenant/TenantList.vue'),
      meta: { requiresAuth: true, superAdmin: true },
    },
    */
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
  
  if (to.matched.some((record) => record.meta.requiresAuth)) {
    if (!auth.isAuthenticated) {
      next({ name: 'login' });
    // } else if (to.matched.some((record) => record.meta.superAdmin) && !auth.isSuperAdmin) {
    //   next({ name: 'dashboard' });
    } else {
      next();
    }
  } else if (to.matched.some((record) => record.meta.guest)) {
    if (auth.isAuthenticated && to.name !== 'home') {
      next({ name: 'dashboard' });
    } else {
      next();
    }
  } else {
    next();
  }
});

export default router; 