import { useEffect, useState } from 'react';
import { api } from './services/api';
import type { User } from './types';
import { LoginPage } from './pages/LoginPage';
import { AccountPage } from './pages/AccountPage';
import { DataPage } from './pages/DataPage';
import { LogsPage } from './pages/LogsPage';
import './styles.css';

type Page = 'accounts' | 'data' | 'logs';

export default function App() {
  const [user, setUser] = useState<User | null>(null);
  const [page, setPage] = useState<Page>('accounts');
  const [checking, setChecking] = useState(true);

  useEffect(() => {
    const token = localStorage.getItem('session_token');
    if (!token) { setChecking(false); return; }
    void api<{ user: User }>('/me').then((result) => setUser(result.user)).catch(() => localStorage.removeItem('session_token')).finally(() => setChecking(false));
  }, []);

  if (checking) return <div className="loading-screen">Đang tải...</div>;
  if (!user) return <LoginPage onLogin={() => window.location.reload()} />;

  async function logout() {
    await api('/logout', { method: 'POST' }).catch(() => undefined);
    localStorage.removeItem('session_token');
    setUser(null);
  }

  return <div className="app-shell">
    <aside className="sidebar"><div className="brand">S1-10</div><div className="side-caption">S1-10 · account lock & handover</div><nav><button className={page === 'accounts' ? 'active' : ''} onClick={() => setPage('accounts')}>👤 Tài khoản</button><button className={page === 'data' ? 'active' : ''} onClick={() => setPage('data')}>📁 Dữ liệu</button><button className={page === 'logs' ? 'active' : ''} onClick={() => setPage('logs')}>🧾 Nhật ký bàn giao</button></nav><div className="sidebar-bottom"><span>{user.name}</span><button onClick={() => void logout()}>Đăng xuất</button></div></aside>
    <main className="content">{page === 'accounts' && <AccountPage />}{page === 'data' && <DataPage />}{page === 'logs' && <LogsPage />}</main>
  </div>;
}
