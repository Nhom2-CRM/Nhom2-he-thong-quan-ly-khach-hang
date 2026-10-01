export interface User {
  id: number;
  name: string;
  email: string;
  role: 'admin' | 'manager' | 'staff';
  is_active: boolean;
  created_at?: string;
}

export interface LoginPayload {
  email: string;
  password: string;
  remember?: boolean;
}

export interface AuthResponse {
  success: boolean;
  data: { token: string; user: User };
  message: string;
}

export type CustomerStatus = 'lead' | 'prospect' | 'active' | 'inactive';

export interface Customer {
  id: number;
  name: string;
  email: string | null;
  phone: string | null;
  address: string | null;
  company: string | null;
  status: CustomerStatus;
  assigned_to: number | null;
  notes: string | null;
  created_at: string;
  updated_at: string;
  assigned_user?: User;
}

export interface CustomerPayload {
  name: string;
  email?: string;
  phone?: string;
  address?: string;
  company?: string;
  status?: CustomerStatus;
  assigned_to?: number;
  notes?: string;
}

export type CampaignStatus = 'draft' | 'active' | 'paused' | 'completed';

export interface Campaign {
  id: number;
  name: string;
  description: string | null;
  status: CampaignStatus;
  starts_at: string | null;
  ends_at: string | null;
  budget: string | null;
  created_by: number;
  customer_id: number | null;
  created_at: string;
  updated_at: string;
  creator?: User;
  customer?: Customer;
}

export interface CampaignPayload {
  name: string;
  description?: string;
  status?: CampaignStatus;
  starts_at?: string;
  ends_at?: string;
  budget?: number;
  customer_id?: number;
}

export interface PaginatedResponse<T> {
  success: boolean;
  data: {
    data: T[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
    from: number;
    to: number;
  };
}

export interface SingleResponse<T> {
  success: boolean;
  data: T;
  message?: string;
}

export interface ErrorAction {
  label: string;
  url: string;
}

export interface ApiError {
  status_code: number;
  title: string;
  message: string;
  primary_action: ErrorAction;
  secondary_action: ErrorAction | null;
}

export interface ApiErrorResponse {
  success: false;
  error: ApiError;
}

export interface CustomerFilters {
  search?: string;
  status?: CustomerStatus | '';
  assigned_to?: number | '';
  per_page?: number;
  page?: number;
}

export interface CampaignFilters {
  search?: string;
  status?: CampaignStatus | '';
  per_page?: number;
  page?: number;
}
