import type {ApiResponse,User} from '../types';
const API=import.meta.env.VITE_API_URL ?? 'http://localhost:8000/api';
const token=()=>localStorage.getItem('crm_token') ?? '';
async function request<T>(path:string,options:RequestInit={}):Promise<T>{const r=await fetch(`${API}${path}`,{...options,headers:{Accept:'application/json','Content-Type':'application/json',Authorization:`Bearer ${token()}`,...options.headers}}); const body=await r.json().catch(()=>({})); if(!r.ok) throw new Error(body.message||'Có lỗi xảy ra'); return body as T;}
export async function login(email:string,password:string){const r=await request<ApiResponse<{token:string;user:User}>>('/auth/login',{method:'POST',headers:{Authorization:''},body:JSON.stringify({email,password})}); localStorage.setItem('crm_token',r.data.token); return r.data.user;}
export async function me(){const r=await request<ApiResponse<{user:User}>>('/auth/me'); return r.data.user;}
export async function logout(){try{await request('/auth/logout',{method:'POST'})}finally{localStorage.removeItem('crm_token')}}
export async function getCustomers(){const r=await request<ApiResponse<any>>('/customers'); return r.data;}
export async function getCampaigns(){const r=await request<ApiResponse<any>>('/campaigns'); return r.data;}
