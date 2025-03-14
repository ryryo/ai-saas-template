export interface Tenant {
  id: number;
  name: string;
  email: string;
  domain?: string;
  role: 'super_admin' | 'tenant_admin';
  plan_type: 'free' | 'standard' | 'premium';
  status: 'active' | 'inactive' | 'suspended';
  settings?: Record<string, any>;
  email_verified_at?: string;
  last_login_at?: string;
  created_at: string;
  updated_at: string;
}

export interface LoginCredentials {
  email: string;
  password: string;
  remember?: boolean;
}

export interface RegisterData {
  name: string;
  email: string;
  password: string;
  password_confirmation: string;
  domain?: string;
}

export interface AuthState {
  tenant: Tenant | null;
  isAuthenticated: boolean;
  isLoading: boolean;
  error?: string | null;
}

export interface AuthResponse {
  tenant: Tenant;
  token: string;
} 