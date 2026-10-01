import { useEffect, useState, type FormEvent } from "react";
import { useNavigate } from "react-router-dom";
import { login } from "../services/api";
import "./Login.css";

function Login() {
  const navigate = useNavigate();

  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [message, setMessage] = useState("");
  const [loading, setLoading] = useState(false);

  // Hiển thị thông báo nếu phiên đăng nhập đã hết hạn
  useEffect(() => {
    const loginMessage = sessionStorage.getItem("login_message");

    if (loginMessage) {
      setMessage(loginMessage);
      sessionStorage.removeItem("login_message");
    }
  }, []);

  async function handleSubmit(e: FormEvent) {
    e.preventDefault();

    setMessage("");
    setLoading(true);

    try {
      const result = await login({
        email,
        password,
      });

      // Lưu thông tin người dùng
      localStorage.setItem("user", JSON.stringify(result.user));

      // Lưu token phiên đăng nhập
      localStorage.setItem("session_token", result.session_token);

      // Chuyển trang theo vai trò
      navigate(result.redirect);
    } catch (error: any) {
      setMessage(error.message || "Đăng nhập thất bại.");
    } finally {
      setLoading(false);
    }
  }

  return (
    <div className="login-page">
      <div className="login-left">
        <div className="brand">
          <div className="brand-logo">CRM</div>

          <h1>Quản lý khách hàng</h1>

          <p>Hệ thống quản lý thông tin khách hàng dành cho doanh nghiệp.</p>
        </div>
      </div>

      <div className="login-right">
        <div className="login-card">
          <div className="login-header">
            <h2>Đăng nhập</h2>

            <p>Đăng nhập bằng email công ty của bạn</p>
          </div>

          <form onSubmit={handleSubmit}>
            <div className="form-group">
              <label>Email công ty</label>

              <input
                type="email"
                placeholder="name@company.com"
                value={email}
                onChange={(e) => setEmail(e.target.value)}
                required
              />
            </div>

            <div className="form-group">
              <label>Mật khẩu</label>

              <input
                type="password"
                placeholder="Nhập mật khẩu"
                value={password}
                onChange={(e) => setPassword(e.target.value)}
                required
              />
            </div>

            {message && <div className="error-message">{message}</div>}

            <button className="login-button" type="submit" disabled={loading}>
              {loading ? "Đang đăng nhập..." : "Đăng nhập"}
            </button>
          </form>

          <div className="login-footer">CRM System © 2026</div>
        </div>
      </div>
    </div>
  );
}

export default Login;
