import { useEffect, useMemo, useState } from 'react';
import './App.css';
import { UserAssignmentComponent } from './components/UserAssignmentComponent';
import {
  apiMessage,
  getAssignmentOptions,
  getCurrentUser,
  getUsers,
  login,
  logout,
  updateAssignments,
} from './services/api';
import type { AssignmentOptions, UserSummary } from './types';

function App() {
  const [currentUser, setCurrentUser] = useState<UserSummary | null>(null);
  const [users, setUsers] = useState<UserSummary[]>([]);
  const [options, setOptions] = useState<AssignmentOptions>({ roles: [], business_groups: [] });
  const [selectedUserId, setSelectedUserId] = useState<number | null>(null);
  const [loading, setLoading] = useState(true);
  const [saving, setSaving] = useState(false);
  const [message, setMessage] = useState('');
  const [error, setError] = useState('');
  const [email, setEmail] = useState('admin@company.com');
  const [password, setPassword] = useState('Admin1234');

  const selectedUser = useMemo(
    () => users.find((user) => user.id === selectedUserId) ?? null,
    [users, selectedUserId],
  );

  const loadAdminData = async () => {
    const [me, userList, assignmentOptions] = await Promise.all([
      getCurrentUser(),
      getUsers(),
      getAssignmentOptions(),
    ]);
    setCurrentUser(me);
    setUsers(userList);
    setOptions(assignmentOptions);
    if (userList.length > 0) setSelectedUserId((value) => value ?? userList[0].id);
  };

  useEffect(() => {
    const token = localStorage.getItem('session_token');
    if (!token) {
      setLoading(false);
      return;
    }

    loadAdminData()
      .catch((err) => {
        setError(apiMessage(err));
        setCurrentUser(null);
      })
      .finally(() => setLoading(false));
  }, []);

  const handleLogin = async (event: React.FormEvent) => {
    event.preventDefault();
    setError('');
    setMessage('');
    setLoading(true);

    try {
      await login(email, password);
      await loadAdminData();
    } catch (err) {
      setError(apiMessage(err));
    } finally {
      setLoading(false);
    }
  };

  const handleSave = async (roleIds: number[], groupIds: number[]) => {
    if (!selectedUser) return;
    setSaving(true);
    setError('');
    setMessage('');

    try {
      const updated = await updateAssignments(selectedUser.id, roleIds, groupIds);
      setUsers((current) => current.map((user) => (user.id === updated.id ? updated : user)));
      if (currentUser?.id === updated.id) setCurrentUser(updated);
      setMessage('Cập nhật vai trò và nhóm kinh doanh thành công.');
    } catch (err) {
      setError(apiMessage(err));
    } finally {
      setSaving(false);
    }
  };

  const handleLogout = async () => {
    await logout();
    setCurrentUser(null);
    setUsers([]);
    setSelectedUserId(null);
    setMessage('');
    setError('');
  };

  if (loading) return <div className="center-box">Đang tải dữ liệu...</div>;

  if (!currentUser) {
    return (
      <main className="login-page">
        <form className="login-card" onSubmit={handleLogin}>
          <h1>Quản trị vai trò</h1>
          <p>Đăng nhập bằng tài khoản quản trị hệ thống.</p>
          {error && <div className="message error">{error}</div>}
          <label>Email<input value={email} onChange={(e) => setEmail(e.target.value)} type="email" required /></label>
          <label>Mật khẩu<input value={password} onChange={(e) => setPassword(e.target.value)} type="password" required /></label>
          <button className="primary" type="submit">Đăng nhập</button>
          <small>Tài khoản demo: admin@company.com / Admin1234</small>
        </form>
      </main>
    );
  }

  return (
    <main className="page-shell">
      <header className="topbar">
        <div>
          <h1>Phân quyền & Nhóm kinh doanh</h1>
          <p>Quản trị vai trò và cây tổ chức quyết định phạm vi dữ liệu người dùng nhìn thấy.</p>
        </div>
        <div className="current-user">
          <strong>{currentUser.name}</strong>
          <span>{currentUser.roles.map((role) => role.display_name).join(', ')}</span>
          <button className="ghost" onClick={handleLogout}>Đăng xuất</button>
        </div>
      </header>

      {error && <div className="message error">{error}</div>}
      {message && <div className="message success">{message}</div>}

      <div className="workspace">
        <aside className="user-list">
          <h2>Người dùng</h2>
          {users.map((user) => (
            <button
              key={user.id}
              className={selectedUserId === user.id ? 'user-row active' : 'user-row'}
              onClick={() => {
                setSelectedUserId(user.id);
                setError('');
                setMessage('');
              }}
            >
              <strong>{user.name}</strong>
              <span>{user.roles.map((role) => role.display_name).join(', ') || 'Chưa có vai trò'}</span>
            </button>
          ))}
        </aside>

        <section className="content-panel">
          {selectedUser ? (
            <UserAssignmentComponent
              user={selectedUser}
              currentUserId={currentUser.id}
              roles={options.roles}
              groups={options.business_groups}
              saving={saving}
              onSave={handleSave}
            />
          ) : (
            <div className="empty-state">Chọn một người dùng để phân quyền.</div>
          )}
        </section>
      </div>
    </main>
  );
}

export default App;
