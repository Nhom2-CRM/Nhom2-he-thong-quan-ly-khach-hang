const API_URL = "http://127.0.0.1:8000/api";

export interface LoginData {
  email: string;
  password: string;
}

export async function login(data: LoginData) {
  const response = await fetch(`${API_URL}/login`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      Accept: "application/json",
    },
    body: JSON.stringify(data),
  });

  const result = await response.json();

  if (!response.ok) {
    throw result;
  }

  return result;
}

function getSessionToken() {
  return localStorage.getItem("session_token");
}

export async function authRequest(url: string, options: RequestInit = {}) {
  const token = getSessionToken();

  const response = await fetch(`${API_URL}${url}`, {
    ...options,
    headers: {
      "Content-Type": "application/json",
      Accept: "application/json",
      ...(token
        ? {
            Authorization: `Bearer ${token}`,
          }
        : {}),
      ...options.headers,
    },
  });

  const result = await response.json();

  if (response.status === 401 && result.code === "SESSION_EXPIRED") {
    localStorage.removeItem("user");
    localStorage.removeItem("session_token");

    sessionStorage.setItem(
      "login_message",
      "Phiên đăng nhập đã hết hạn. Vui lòng đăng nhập lại.",
    );

    window.location.href = "/login";

    throw result;
  }

  if (!response.ok) {
    throw result;
  }

  return result;
}

export async function logout() {
  return authRequest("/logout", {
    method: "POST",
  });
}

export async function getCurrentUser() {
  return authRequest("/me");
}
