import { useState } from 'react';
import type { FormEvent } from 'react';
import { useNavigate } from 'react-router-dom';
import { api } from '../services/api';

export default function Login() {
  const [email, setEmail] = useState('staffa@company.com');
  const [password, setPassword] = useState('12345678a');
  const [error, setError] = useState('');
  const navigate = useNavigate();

  async function submit(e: FormEvent) {
    e.preventDefault();
    setError('');
    try {
      const { data } = await api.post('/api/login', { email, password });
      localStorage.setItem('session_token', data.session_token);
      localStorage.setItem('user', JSON.stringify(data.user));
      navigate('/customers');
    } catch (err: any) {
      setError(err.response?.data?.message || 'Đăng nhập thất bại.');
    }
  }

  return <div className="login-page"><form className="login-card" onSubmit={submit}>
    <h1>CRM - S1-05</h1>
    <p>Đăng nhập để kiểm tra phạm vi dữ liệu</p>
    <input value={email} onChange={e => setEmail(e.target.value)} placeholder="Email" />
    <input value={password} onChange={e => setPassword(e.target.value)} type="password" placeholder="Mật khẩu" />
    {error && <div className="error">{error}</div>}
    <button type="submit">Đăng nhập</button>
  </form></div>;
}
