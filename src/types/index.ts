export type UserRole = 'SALES_REP' | 'TEAM_LEADER' | 'SALES_DIRECTOR';
export type DataScope = 'MINE' | 'TEAM' | 'ALL';

export interface User {
  id: number;
  name: string;
  role: UserRole;
  scope: DataScope;
  business_group_id: number | null;
}

export interface ScopedRecord {
  id: number;
  name: string;
  status?: string | null;
  value?: number | null;
  description?: string | null;
  owner_id: number;
  business_group_id: number;
  ownerName?: string | null;
}
