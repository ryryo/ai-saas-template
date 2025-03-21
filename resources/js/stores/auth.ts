import { defineStore } from 'pinia';
import axios from 'axios';
import type { AuthState, RegisterData, Tenant, AuthResponse } from '../types/auth';

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
        const response = await axios.post<AuthResponse>('/api/auth/login', { email, password });
        this.tenant = response.data.tenant;
        this.isAuthenticated = true;
        return true;
      } catch (error) {
        throw error;
      } finally {
        this.isLoading = false;
      }
    },

    async logout() {
      this.isLoading = true;
      try {
        await axios.post('/api/auth/logout');
        this.tenant = null;
        this.isAuthenticated = false;
        return true;
      } catch (error) {
        throw error;
      } finally {
        this.isLoading = false;
      }
    },

    async register(data: RegisterData) {
      this.isLoading = true;
      try {
        const response = await axios.post<AuthResponse>('/api/auth/register', data);
        this.tenant = response.data.tenant;
        this.isAuthenticated = true;
        return true;
      } catch (error) {
        throw error;
      } finally {
        this.isLoading = false;
      }
    },
  },
}); 