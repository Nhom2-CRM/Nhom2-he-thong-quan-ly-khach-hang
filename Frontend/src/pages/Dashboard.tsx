import { logout } from "../services/api";
import { useSessionKeepAlive } from "../hooks/useSessionKeepAlive";
import "./Dashboard.css";

function Dashboard() {
  useSessionKeepAlive();

  const user = JSON.parse(localStorage.getItem("user") || "{}");

  async function handleLogout() {
    try {
      // Gọi backend để vô hiệu phiên ngay phía server
      await logout();
    } catch {
      // Nếu API lỗi vẫn tiếp tục xóa dữ liệu phía client
    } finally {
      localStorage.removeItem("user");
      localStorage.removeItem("session_token");

      window.location.href = "/login";
    }
  }

  return (
    <div className="dashboard-page">
      <aside className="sidebar">
        <div className="sidebar-logo">CRM</div>

        <nav className="sidebar-menu">
          <a className="menu-item active">Tổng quan</a>

          <a className="menu-item">Khách hàng</a>

          <a className="menu-item">Chiến dịch</a>

          <a className="menu-item">Báo cáo</a>

          <a className="menu-item">Cài đặt</a>
        </nav>

        <button className="logout-btn" onClick={handleLogout}>
          Đăng xuất
        </button>
      </aside>

      <main className="dashboard-main">
        <header className="topbar">
          <div>
            <h1>Trang chủ CRM</h1>

            <p>Chào mừng trở lại, {user.name}</p>
          </div>

          <div className="user-box">
            <div className="avatar">{user.name?.charAt(0) || "U"}</div>

            <div>
              <strong>{user.name}</strong>
              <span>{user.role}</span>
            </div>
          </div>
        </header>

        <section className="stats-grid">
          <div className="stat-card">
            <span>Tổng khách hàng</span>
            <strong>128</strong>
            <small>+12 khách hàng mới</small>
          </div>

          <div className="stat-card">
            <span>Khách hàng tiềm năng</span>
            <strong>42</strong>
            <small>Đang cần chăm sóc</small>
          </div>

          <div className="stat-card">
            <span>Chiến dịch</span>
            <strong>8</strong>
            <small>3 chiến dịch đang chạy</small>
          </div>

          <div className="stat-card">
            <span>Tỷ lệ chuyển đổi</span>
            <strong>24%</strong>
            <small>Tăng 4% tháng này</small>
          </div>
        </section>

        <section className="content-card">
          <div className="content-header">
            <div>
              <h2>Danh mục khách hàng của tôi</h2>

              <p>Quản lý các khách hàng được phân công</p>
            </div>

            <button className="primary-btn">+ Thêm khách hàng</button>
          </div>

          <div className="customer-table">
            <div className="table-row table-head">
              <span>Khách hàng</span>
              <span>Email</span>
              <span>Trạng thái</span>
              <span>Phụ trách</span>
            </div>

            <div className="table-row">
              <span>Nguyễn Văn An</span>
              <span>an@example.com</span>

              <span>
                <b className="status active-status">Đang hoạt động</b>
              </span>

              <span>{user.name}</span>
            </div>

            <div className="table-row">
              <span>Trần Minh Anh</span>
              <span>minhanh@example.com</span>

              <span>
                <b className="status lead-status">Tiềm năng</b>
              </span>

              <span>{user.name}</span>
            </div>

            <div className="table-row">
              <span>Lê Thu Hà</span>
              <span>thuha@example.com</span>

              <span>
                <b className="status active-status">Đang hoạt động</b>
              </span>

              <span>{user.name}</span>
            </div>
          </div>
        </section>
      </main>
    </div>
  );
}

export default Dashboard;
