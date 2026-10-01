import axios, { AxiosError } from 'axios';
import type {
  AuthResponse, LoginPayload,
  Customer, CustomerPayload, CustomerFilters,
  Campaign, CampaignPayload, CampaignFilters,
  PaginatedResponse, SingleResponse, ApiErrorResponse,
} from '../types';

export const http = axios.create({
  baseURL: import.meta.env.VITE_API_URL ?? 'http://localhost:8000/api',
  headers: { 'Content-Type': 'application/json', Accept: 'application/json' },
});

http.interceptors.request.use((config) => {
  const token = localStorage.getItem('token');
  if (token) config.headers.Authorization = `Bearer ${token}`;
  return config;
});

/**
 * S1-07: mọi lỗi API quan trọng đều chuyển đến trang lỗi dùng chung.
 * Payload được lưu tạm trong sessionStorage để vẫn còn sau khi điều hướng.
 */
http.interceptors.response.use(
  (res) => res,
  (err: AxiosError<ApiErrorResponse>) => {
    const apiErr = err.response?.data?.error;

    if (apiErr && [401, 403, 404, 419, 500].includes(apiErr.status_code)) {
      sessionStorage.setItem('last_api_error', JSON.stringify(apiErr));

      if (apiErr.status_code === 401) {
        localStorage.removeItem('token');
      }

      if (!window.location.pathname.startsWith('/error')) {
        window.location.assign(`/error?status=${apiErr.status_code}`);
      }

      const error = new Error(apiErr.message) as Error & { apiError: typeof apiErr };
      error.apiError = apiErr;
      return Promise.reject(error);
    }

    return Promise.reject(err);
  }
);

export const authApi = {
  login: (payload: LoginPayload) =>
    http.post<AuthResponse>('/login', payload).then((r) => r.data),
  logout: () => http.post('/logout').then((r) => r.data),
  me: () => http.get('/me').then((r) => r.data),
};

export const customersApi = {
  list: (filters: CustomerFilters = {}) =>
    http.get<PaginatedResponse<Customer>>('/customers', { params: filters }).then((r) => r.data),
  get: (id: number) =>
    http.get<SingleResponse<Customer>>(`/customers/${id}`).then((r) => r.data),
  create: (payload: CustomerPayload) =>
    http.post<SingleResponse<Customer>>('/customers', payload).then((r) => r.data),
  update: (id: number, payload: Partial<CustomerPayload>) =>
    http.put<SingleResponse<Customer>>(`/customers/${id}`, payload).then((r) => r.data),
  remove: (id: number) =>
    http.delete(`/customers/${id}`).then((r) => r.data),
};

export const campaignsApi = {
  list: (filters: CampaignFilters = {}) =>
    http.get<PaginatedResponse<Campaign>>('/campaigns', { params: filters }).then((r) => r.data),
  get: (id: number) =>
    http.get<SingleResponse<Campaign>>(`/campaigns/${id}`).then((r) => r.data),
  create: (payload: CampaignPayload) =>
    http.post<SingleResponse<Campaign>>('/campaigns', payload).then((r) => r.data),
  update: (id: number, payload: Partial<CampaignPayload>) =>
    http.put<SingleResponse<Campaign>>(`/campaigns/${id}`, payload).then((r) => r.data),
  changeStatus: (id: number, status: string) =>
    http.patch(`/campaigns/${id}/status`, { status }).then((r) => r.data),
  remove: (id: number) =>
    http.delete(`/campaigns/${id}`).then((r) => r.data),
};
