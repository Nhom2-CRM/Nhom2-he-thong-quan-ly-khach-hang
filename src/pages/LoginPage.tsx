import { FormEvent, useState } from 'react';
import { login } from '../services/api';

export function LoginPage({ onLogin }: { onLogin: () => void }) {
  const [email, setEmail] = useState('admin@company.com');
  const [password, setPassword] = useState('Admin1234');
  const [error, setError] = useState('');
  const [loading, setLoading] = useState(false);

  async function submit(event: FormEvent) {
    event.preventDefault();
    setLoading(true);
    setError('');
    try {
      const result = await login(email, password);
      localStorage.setItem('session_token', result.session_token);
      onLogin();
    } catch (err) {
      setError(err instanceof Error ? err.message : 'Đăng nhập thất bại.');
    } finally {
      setLoading(false);
    }
  }

  return (
    <main className="auth-page">
      <form className="auth-card" onSubmit={submit}>
        <div className="brand">S1-10</div>
        <h1>Quản trị tài khoản</h1>
        <p className="muted">Đăng nhập để quản lý khóa tài khoản và bàn giao dữ liệu.</p>
        <label>Email<input value={email} onChange={(e) => setEmail(e.target.value)} type="email" /></label>
        <label>Mật khẩu<input value={password} onChange={(e) => setPassword(e.target.value)} type="password" /></label>
        {error && <div className="error">{error}</div>}
        <button className="primary full" disabled={loading}>{loading ? 'Đang đăng nhập...' : 'Đăng nhập'}</button>
      </form>
    </main>
  );
}
