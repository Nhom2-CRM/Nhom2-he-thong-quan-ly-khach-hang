import {Navigate,Route,Routes} from 'react-router-dom';
import type {ReactNode} from 'react';
import AppLayout from '../layouts/AppLayout';
import Login from '../pages/Login';
import Dashboard from '../pages/Dashboard';
import Customers from '../pages/Customers';
import Campaigns from '../pages/Campaigns';
import SimplePage from '../pages/SimplePage';
import {useAuth} from '../hooks/useAuth';
import type {Permission} from '../types';

function Guard({children}:{children:ReactNode}){const{user,loading}=useAuth();if(loading)return <div style={{padding:30}}>Đang tải...</div>;return user?children:<Navigate to="/login" replace/>}
function PermissionGuard({permission,children}:{permission:Permission;children:ReactNode}){const{can}=useAuth();return can(permission)?children:<Navigate to="/" replace/>}
export default function AppRoutes(){return <Routes><Route path="/login" element={<Login/>}/><Route path="/" element={<Guard><AppLayout/></Guard>}><Route index element={<PermissionGuard permission="dashboard.view"><Dashboard/></PermissionGuard>}/><Route path="customers" element={<PermissionGuard permission="customers.view"><Customers/></PermissionGuard>}/><Route path="campaigns" element={<PermissionGuard permission="campaigns.view"><Campaigns/></PermissionGuard>}/><Route path="reports" element={<PermissionGuard permission="reports.view"><SimplePage title="Báo cáo"/></PermissionGuard>}/><Route path="users" element={<PermissionGuard permission="users.manage"><SimplePage title="Người dùng"/></PermissionGuard>}/></Route><Route path="*" element={<Navigate to="/" replace/>}/></Routes>}
