import { useQuery } from '@tanstack/react-query';
import { api } from '../services/api';

interface FetchParams {
  search?: string;
  page?: number;
}

// Fetch danh sách khách hàng (backend sẽ dựa vào token để tự lọc theo MINE / TEAM / ALL)
export const useCustomers = (params: FetchParams) => {
  return useQuery({
    queryKey: ['customers', params],
    queryFn: async () => {
      const { data } = await api.get('/api/customers', { params });
      return data;
    },
  });
};

// Xuất danh sách ra file Excel
export const exportCustomersToExcel = async (searchQuery: string) => {
  try {
    const response = await api.get('/api/customers/export', {
      params: { search: searchQuery },
      responseType: 'blob',
    });
    const url = window.URL.createObjectURL(new Blob([response.data]));
    const link = document.createElement('a');
    link.href = url;
    link.setAttribute('download', 'Danh_sach_khach_hang.xlsx');
    document.body.appendChild(link);
    link.click();
    link.remove();
  } catch (error) {
    console.error('Lỗi khi xuất file Excel', error);
  }
};