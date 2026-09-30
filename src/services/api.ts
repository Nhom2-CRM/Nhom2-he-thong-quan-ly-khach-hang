import axios from 'axios';
import type { AssignmentOptions, UserSummary } from '../types';

const api = axios.create({
  baseURL: import.meta.env.VITE_API_URL || 'http://127.0.0.1:8000/api',
  headers: { Accept: 'application/json' },
});

api.interceptors.request.use((config) => {
  const token = localStorage.getItem('session_token');
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
});

api.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response?.status === 401) {
      localStorage.removeItem('session_token');
      localStorage.removeItem('current_user');
    }
    return Promise.reject(error);
  },
);

export async function login(email: string, password: string) {
  const { data } = await api.post('/login', { email, password });
  localStorage.setItem('session_token', data.session_token);
  localStorage.setItem('current_user', JSON.stringify(data.user));
  return data.user as UserSummary;
}

export async function logout() {
  try {
    await api.post('/logout');
  } finally {
    localStorage.removeItem('session_token');
    localStorage.removeItem('current_user');
  }
}

export async function getCurrentUser(): Promise<UserSummary> {
  const { data } = await api.get('/me');
  localStorage.setItem('current_user', JSON.stringify(data.user));
  return data.user;
}

export async function getUsers(): Promise<UserSummary[]> {
  const { data } = await api.get('/admin/users');
  return data.users;
}

export async function getAssignmentOptions(): Promise<AssignmentOptions> {
  const { data } = await api.get('/admin/assignment-options');
  return {
    roles: data.roles,
    business_groups: data.business_groups,
  };
}

export async function updateAssignments(
  userId: number,
  roleIds: number[],
  groupIds: number[],
): Promise<UserSummary> {
  const { data } = await api.put(`/admin/users/${userId}/assignments`, {
    role_ids: roleIds,
    business_group_ids: groupIds,
  });
  return data.user;
}

export function apiMessage(error: unknown): string {
  if (axios.isAxiosError(error)) {
    return error.response?.data?.message || 'Không thể kết nối đến máy chủ.';
  }
  return 'Có lỗi xảy ra. Vui lòng thử lại.';
}
