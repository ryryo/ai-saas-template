import { defineStore } from 'pinia';
import axios from 'axios';
import type { AuthState, LoginCredentials, RegisterData, Tenant, AuthResponse } from '../types/auth';

export const useAuthStore = defineStore('auth', {
  state: (): AuthState => ({
    tenant: null,
    isAuthenticated: false,
    isLoading: false,
  }),

  getters: {
    isSuperAdmin: (state): boolean => state.tenant?.role === 'super_admin',
    isTenantAdmin: (state): boolean => state.tenant?.role === 'tenant_admin',
    currentTenant: (state): Tenant | null => state.tenant,
  },

  actions: {
    async initAuth() {
      try {
        const response = await axios.get('/api/auth/me');
        this.tenant = response.data.data;
        this.isAuthenticated = true;
      } catch (error) {
        this.tenant = null;
        this.isAuthenticated = false;
      }
    },

    async login(email: string, password: string) {
      this.isLoading = true;
      try {
        await axios.post('/api/auth/login', { email, password });
        await this.initAuth();
        return true;
      } catch (error) {
        throw error;
      } finally {
        this.isLoading = false;
      }
    },

    async logout() {
      try {
        await axios.post('/api/auth/logout');
      } finally {
        this.tenant = null;
        this.isAuthenticated = false;
      }
    },

    async fetchCurrentTenant() {
      this.isLoading = true;
      try {
        const response = await axios.get<{ tenant: Tenant }>('/api/tenant');
        this.tenant = response.data.tenant;
        this.isAuthenticated = true;
        return response.data.tenant;
      } catch (error: any) {
        this.tenant = null;
        this.isAuthenticated = false;
        throw error;
      } finally {
        this.isLoading = false;
      }
    },

    setAuthData(data: AuthResponse) {
      this.tenant = data.tenant;
      this.isAuthenticated = true;
      // トークンをlocalStorageに保存
      localStorage.setItem('token', data.token);
      // Axiosのデフォルトヘッダーにトークンを設定
      axios.defaults.headers.common['Authorization'] = `Bearer ${data.token}`;
    },

    clearAuthData() {
      this.tenant = null;
      this.isAuthenticated = false;
      // トークンを削除
      localStorage.removeItem('token');
      delete axios.defaults.headers.common['Authorization'];
    },
  },
}); 