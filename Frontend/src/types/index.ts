export type Permission = 'dashboard.view'|'customers.view'|'customers.create'|'customers.update'|'customers.delete'|'campaigns.view'|'campaigns.create'|'campaigns.update'|'campaigns.delete'|'reports.view'|'users.manage';
export interface User {id:number;name:string;email:string;role:string;businessGroup:{id:number|null;name:string|null};permissions:Permission[]}
export interface ApiResponse<T>{status:string;message?:string;data:T}
