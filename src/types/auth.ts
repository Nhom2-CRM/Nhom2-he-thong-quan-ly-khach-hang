export interface ChangePasswordPayload {
  current_password: string;
  new_password: string;
  new_password_confirmation: string;
}

export interface ApiResponse {
  success?: boolean;
  message: string;
  revoked_sessions?: number;
}
