import { useQuery } from '@tanstack/react-query';
import { api } from '../services/api';

export type ResourceName = 'customers' | 'opportunities' | 'activities' | 'quotes';

export function useScopedResource(resource: ResourceName, search: string) {
  return useQuery({
    queryKey: [resource, search],
    queryFn: async () => {
      const { data } = await api.get(`/api/${resource}`, { params: { search } });
      return data;
    },
  });
}

export async function exportScopedResource(resource: ResourceName, search: string, filename: string) {
  const response = await api.get(`/api/${resource}/export`, {
    params: { search },
    responseType: 'blob',
  });
  const url = URL.createObjectURL(response.data);
  const a = document.createElement('a');
  a.href = url;
  a.download = filename;
  document.body.appendChild(a);
  a.click();
  a.remove();
  URL.revokeObjectURL(url);
}
