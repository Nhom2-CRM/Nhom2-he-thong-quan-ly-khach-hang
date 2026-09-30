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
