const API_URL = import.meta.env.VITE_API_URL ?? 'http://127.0.0.1:8000/api';

export async function api<T>(path: string, options: RequestInit = {}): Promise<T> {
  const token = localStorage.getItem('session_token');
  const response = await fetch(`${API_URL}${path}`, {
    ...options,
    headers: {
      Accept: 'application/json',
      'Content-Type': 'application/json',
      ...(token ? { Authorization: `Bearer ${token}` } : {}),
      ...(options.headers ?? {}),
    },
  });

  const body = await response.json().catch(() => ({}));

  if (response.status === 401 && body.code === 'SESSION_EXPIRED') {
    localStorage.removeItem('session_token');
    throw new Error(body.message ?? 'Phiên đăng nhập đã hết hạn.');
  }

  if (!response.ok) {
    throw new Error(body.message ?? 'Có lỗi xảy ra.');
  }

  return body as T;
}

export function login(email: string, password: string) {
  return api<{ success: boolean; session_token: string; user: import('../types').User }>('/login', {
    method: 'POST',
    body: JSON.stringify({ email, password }),
  });
}
