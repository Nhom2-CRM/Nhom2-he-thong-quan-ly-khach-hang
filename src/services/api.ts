import axios from 'axios';
import type { ChangePasswordPayload, ApiResponse } from '../types/auth';

const api = axios.create({
  baseURL: 'http://127.0.0.1:8000/api',
  headers: {
    'Content-Type': 'application/json',
    Accept: 'application/json',
  },
});

api.interceptors.request.use((config) => {
  // Dùng cùng token với S1-02 (user_sessions), không dùng access_token của Sanctum.
  const token = localStorage.getItem('session_token');

  if (token && config.headers) {
    config.headers.Authorization = `Bearer ${token}`;
  }

  return config;
});

api.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response?.status === 401 && error.response?.data?.code === 'SESSION_EXPIRED') {
      localStorage.removeItem('session_token');
      localStorage.removeItem('user');
      sessionStorage.setItem('login_message', 'Phiên đăng nhập đã hết hạn. Vui lòng đăng nhập lại.');
    }

    return Promise.reject(error);
  },
);

export const changePasswordApi = async (payload: ChangePasswordPayload): Promise<ApiResponse> => {
  const response = await api.post<ApiResponse>('/change-password', payload);
  return response.data;
};

export default api;
