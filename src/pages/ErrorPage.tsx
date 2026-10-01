import { useEffect, useMemo } from 'react';
import { useLocation, useNavigate, useRouteError } from 'react-router-dom';
import type { ApiError } from '../types';

interface Props {
  statusCode?: number;
  title?: string;
  message?: string;
  primaryAction?: { label: string; url: string };
  secondaryAction?: { label: string; url: string } | null;
}

const defaultsByCode: Record<number, Required<Omit<Props, 'secondaryAction'>> & { secondaryAction: Props['secondaryAction'] }> = {
  401: {
    statusCode: 401,
    title: 'Bạn cần đăng nhập',
    message: 'Phiên đăng nhập đã hết hạn hoặc bạn chưa đăng nhập.',
    primaryAction: { label: 'Đăng nhập lại', url: '/login' },
    secondaryAction: null,
  },
  403: {
    statusCode: 403,
    title: 'Bạn không có quyền truy cập',
    message: 'Tài khoản của bạn không đủ quyền để xem nội dung này.',
    primaryAction: { label: 'Quay lại trang trước', url: '__BACK__' },
    secondaryAction: { label: 'Về Dashboard', url: '/dashboard' },
  },
  404: {
    statusCode: 404,
    title: 'Không tìm thấy trang',
    message: 'Đường dẫn bạn truy cập không tồn tại hoặc đã bị thay đổi.',
    primaryAction: { label: 'Về Dashboard', url: '/dashboard' },
    secondaryAction: { label: 'Quay lại trang trước', url: '__BACK__' },
  },
  419: {
    statusCode: 419,
    title: 'Phiên làm việc đã hết hạn',
    message: 'Trang đã hết hạn do không hoạt động trong thời gian dài. Vui lòng tải lại.',
    primaryAction: { label: 'Tải lại trang', url: '__RELOAD__' },
    secondaryAction: { label: 'Về Dashboard', url: '/dashboard' },
  },
  500: {
    statusCode: 500,
    title: 'Đã có lỗi xảy ra',
    message: 'Hệ thống gặp sự cố. Vui lòng thử lại sau ít phút.',
    primaryAction: { label: 'Thử lại', url: '__RELOAD__' },
    secondaryAction: { label: 'Về Dashboard', url: '/dashboard' },
  },
};

function readStoredApiError(): ApiError | null {
  const raw = sessionStorage.getItem('last_api_error');
  if (!raw) return null;

  try {
    return JSON.parse(raw) as ApiError;
  } catch {
    return null;
  }
}

export default function ErrorPage(props: Props) {
  const routeError = useRouteError() as (Error & { apiError?: ApiError }) | null;
  const navigate = useNavigate();
  const location = useLocation();

  const storedError = useMemo(() => readStoredApiError(), []);
  const apiErr = routeError?.apiError ?? storedError;
  const queryCode = Number(new URLSearchParams(location.search).get('status'));
  const code = apiErr?.status_code ?? props.statusCode ?? (Number.isFinite(queryCode) && queryCode > 0 ? queryCode : 500);
  const defaults = defaultsByCode[code] ?? defaultsByCode[500];

  const title = apiErr?.title ?? props.title ?? defaults.title;
  const message = apiErr?.message ?? props.message ?? defaults.message;

  // API backend có thể trả URL của Laravel. Frontend dùng action nội bộ ổn định
  // để không điều hướng nhầm sang backend port.
  const primary = props.primaryAction ?? defaults.primaryAction;
  const secondary = props.secondaryAction ?? defaults.secondaryAction;

  useEffect(() => {
    return () => {
      sessionStorage.removeItem('last_api_error');
    };
  }, []);

  const runAction = (url?: string) => {
    if (!url) return;
    if (url === '__BACK__') {
      navigate(-1);
      return;
    }
    if (url === '__RELOAD__') {
      window.location.reload();
      return;
    }
    navigate(url);
  };

  return (
    <div className="error-page" role="alert" aria-live="polite">
      <div className="error-card">
        <div className="error-code">{code}</div>
        <div className="error-divider" />
        <h1 className="error-title">{title}</h1>
        <p className="error-message">{message}</p>
        <div className="error-actions">
          <button className="btn btn-primary" onClick={() => runAction(primary.url)}>
            {primary.label}
          </button>
          {secondary && (
            <button className="btn btn-secondary" onClick={() => runAction(secondary.url)}>
              {secondary.label}
            </button>
          )}
        </div>
      </div>
    </div>
  );
}
