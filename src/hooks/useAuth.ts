import { create } from 'zustand';
import { persist } from 'zustand/middleware';
import type { User, LoginPayload } from '../types';
import { authApi } from '../services/api';

interface AuthState {
  user: User | null;
  token: string | null;
  login: (payload: LoginPayload) => Promise<void>;
  logout: () => Promise<void>;
  setUser: (user: User) => void;
}

export const useAuth = create<AuthState>()(
  persist(
    (set) => ({
      user: null,
      token: null,

      login: async (payload) => {
        const res = await authApi.login(payload);
        localStorage.setItem('token', res.data.token);
        set({ user: res.data.user, token: res.data.token });
      },

      logout: async () => {
        try { await authApi.logout(); } catch {}
        localStorage.removeItem('token');
        set({ user: null, token: null });
      },

      setUser: (user) => set({ user }),
    }),
    { name: 'auth-store', partialize: (s) => ({ user: s.user, token: s.token }) }
  )
);
