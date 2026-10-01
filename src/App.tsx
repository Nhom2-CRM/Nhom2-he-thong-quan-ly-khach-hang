import { BrowserRouter, Navigate, Route, Routes } from 'react-router-dom';
import { QueryClient, QueryClientProvider } from '@tanstack/react-query';
import { ToastContainer } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
import Login from './pages/Login';
import AppLayout from './layouts/AppLayout';
import ResourceList from './pages/ResourceList';
import ResourceDetail from './pages/ResourceDetail';

const queryClient = new QueryClient();
const protectedLayout = <AppLayout />;

function Guard() {
  return localStorage.getItem('session_token') ? protectedLayout : <Navigate to="/login" replace />;
}

export default function App() {
  return <QueryClientProvider client={queryClient}>
    <BrowserRouter>
      <Routes>
        <Route path="/login" element={<Login />} />
        <Route element={<Guard />}>
          <Route path="/customers" element={<ResourceList resource="customers" title="Khách hàng" singular="khách hàng" exportName="khach_hang.xls" />} />
          <Route path="/customers/:id" element={<ResourceDetail resource="customers" title="Chi tiết khách hàng" />} />
          <Route path="/opportunities" element={<ResourceList resource="opportunities" title="Cơ hội" singular="cơ hội" exportName="co_hoi.xls" />} />
          <Route path="/opportunities/:id" element={<ResourceDetail resource="opportunities" title="Chi tiết cơ hội" />} />
          <Route path="/activities" element={<ResourceList resource="activities" title="Hoạt động" singular="hoạt động" exportName="hoat_dong.xls" />} />
          <Route path="/activities/:id" element={<ResourceDetail resource="activities" title="Chi tiết hoạt động" />} />
          <Route path="/quotes" element={<ResourceList resource="quotes" title="Báo giá" singular="báo giá" exportName="bao_gia.xls" />} />
          <Route path="/quotes/:id" element={<ResourceDetail resource="quotes" title="Chi tiết báo giá" />} />
          <Route path="/" element={<Navigate to="/customers" replace />} />
        </Route>
      </Routes>
    </BrowserRouter>
    <ToastContainer position="top-right" autoClose={3000} />
  </QueryClientProvider>;
}
