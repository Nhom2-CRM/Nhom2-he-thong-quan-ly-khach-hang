import axios from 'axios';
import type { PageMeta, Role, Status, User } from '../types';
const api=axios.create({baseURL:import.meta.env.VITE_API_URL||'http://127.0.0.1:8000/api',headers:{Accept:'application/json'}});
api.interceptors.request.use(c=>{const t=localStorage.getItem('session_token');if(t)c.headers.Authorization=`Bearer ${t}`;return c;});
api.interceptors.response.use(r=>r,e=>{if(e.response?.status===401)localStorage.removeItem('session_token');return Promise.reject(e);});
export async function login(email:string,password:string){const {data}=await api.post('/login',{email,password});localStorage.setItem('session_token',data.session_token);return data.user as User;}
export async function logout(){try{await api.post('/logout')}finally{localStorage.removeItem('session_token')}}
export async function getUsers(params:{search?:string;role?:Role|'';status?:Status|'';page?:number}){const {data}=await api.get('/admin/users',{params});return {users:data.data as User[],meta:data.meta as PageMeta};}
export async function createUser(payload:{name:string;email:string;business_group?:string;role:Role}){const {data}=await api.post('/admin/users',payload);return data;}
export async function updateUser(id:number,payload:Partial<Pick<User,'name'|'email'|'business_group'|'role'|'status'>>){const {data}=await api.put(`/admin/users/${id}`,payload);return data;}
export async function activate(token:string){const {data}=await api.post('/activate',{token});return data;}
export function messageOf(error:unknown){if(axios.isAxiosError(error)){const errors=error.response?.data?.errors;if(errors){const first=Object.values(errors)[0] as string[]|undefined;if(first?.[0])return first[0];}return error.response?.data?.message||'Không thể kết nối máy chủ.';}return 'Có lỗi xảy ra.';}
