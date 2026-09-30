import { useEffect, useState } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import { api } from '../services/api';

export default function CustomerDetail() {
  const { id } = useParams<{ id: string }>();
  const navigate = useNavigate();
  const [customer, setCustomer] = useState<any>(null);

  useEffect(() => {
    const fetchCustomerDetail = async () => {
      try {
        const { data } = await api.get(`/api/customers/${id}`);
        setCustomer(data);
      } catch (error) {
        // Lỗi 403 (Không có quyền) đã được tự động bật Toast thông báo tiếng Việt ở api.ts
      }
    };

    if (id) fetchCustomerDetail();
  }, [id]);

  return (
    <div style={{ padding: '24px' }}>
      <button onClick={() => navigate('/customers')} style={{ marginBottom: '16px' }}>
        ← Quay lại
      </button>

      {customer ? (
        <div>
          <h1>Chi tiết khách hàng</h1>
          <p><strong>Mã KH:</strong> {customer.id}</p>
          <p><strong>Tên:</strong> {customer.name}</p>
          <p><strong>Người quản lý:</strong> {customer.ownerName}</p>
        </div>
      ) : (
        <p>Đang tải hoặc bạn không có quyền xem bản ghi này...</p>
      )}
    </div>
  );
}