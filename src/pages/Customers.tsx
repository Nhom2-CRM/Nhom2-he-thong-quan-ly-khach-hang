import { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { useCustomers, exportCustomersToExcel } from '../hooks/useCustomers';

export default function Customers() {
  const [search, setSearch] = useState('');
  const navigate = useNavigate();
  const { data, isLoading, isError } = useCustomers({ search });

  return (
    <div style={{ padding: '24px' }}>
      <h1>Danh sách khách hàng</h1>

      {/* Thanh tìm kiếm và nút xuất Excel */}
      <div style={{ display: 'flex', gap: '12px', marginBottom: '20px' }}>
        <input
          type="text"
          placeholder="Tìm kiếm khách hàng..."
          value={search}
          onChange={(e) => setSearch(e.target.value)}
          style={{ padding: '8px 12px', width: '300px' }}
        />
        <button 
          onClick={() => exportCustomersToExcel(search)}
          style={{ padding: '8px 16px', cursor: 'pointer' }}
        >
          Xuất Excel
        </button>
      </div>

      {/* Danh sách bản ghi */}
      {isLoading && <p>Đang tải dữ liệu...</p>}
      {isError && <p>Không thể tải dữ liệu.</p>}

      {data && (
        <ul style={{ listStyle: 'none', padding: 0 }}>
          {data.map((customer: any) => (
            <li
              key={customer.id}
              onClick={() => navigate(`/customers/${customer.id}`)}
              style={{
                padding: '12px',
                border: '1px solid #ddd',
                marginBottom: '8px',
                borderRadius: '4px',
                cursor: 'pointer',
              }}
            >
              <strong>{customer.name}</strong> - {customer.ownerName}
            </li>
          ))}
        </ul>
      )}
    </div>
  );
}