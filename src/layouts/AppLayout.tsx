import { NavLink, Outlet, useNavigate } from 'react-router-dom';
import type { User } from '../types';

const labels: Record<string,string> = { MINE: 'Dữ liệu của tôi', TEAM: 'Dữ liệu nhóm tôi', ALL: 'Tất cả dữ liệu' };

export default function AppLayout() {
  const navigate = useNavigate();
  const user: User | null = JSON.parse(localStorage.getItem('user') || 'null');
  const logout = () => { localStorage.removeItem('session_token'); localStorage.removeItem('user'); navigate('/login'); };

  return <div className="app-shell">
    <aside className="sidebar">
      <h2>CRM</h2>
      <div className="user-box"><b>{user?.name}</b><span>{user?.role}</span><small>{user ? labels[user.scope] : ''}</small></div>
      <nav>
        <NavLink to="/customers">Khách hàng</NavLink>
        <NavLink to="/opportunities">Cơ hội</NavLink>
        <NavLink to="/activities">Hoạt động</NavLink>
        <NavLink to="/quotes">Báo giá</NavLink>
      </nav>
      <button onClick={logout}>Đăng xuất</button>
    </aside>
    <main className="content"><Outlet /></main>
  </div>;
}
