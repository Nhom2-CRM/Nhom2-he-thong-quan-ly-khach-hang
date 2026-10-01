export type Role = 'admin' | 'manager' | 'sales';
export type Status = 'pending' | 'active' | 'inactive';
export interface User { id:number; name:string; email:string; business_group:string|null; role:Role; status:Status; activated_at?:string|null; }
export interface PageMeta { current_page:number; last_page:number; per_page:number; total:number; }
