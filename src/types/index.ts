export interface Role {
  id: number;
  name: string;
  display_name: string;
}

export interface BusinessGroup {
  id: number;
  name: string;
  parent_id?: number | null;
}

export interface UserSummary {
  id: number;
  name: string;
  email: string;
  roles: Role[];
  business_groups: BusinessGroup[];
}

export interface AssignmentOptions {
  roles: Role[];
  business_groups: BusinessGroup[];
}
