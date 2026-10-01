# Hệ thống quản lý khách hàng – feature/error (SCRUM-91)

## Tổng quan

Feature này triển khai **trang lỗi dùng chung** cho toàn bộ ứng dụng.  
Thay vì hiển thị trang trắng hoặc stack trace, mọi lỗi HTTP tiêu chuẩn đều được bắt và render một UI thống nhất kèm **hành động gợi ý tiếp theo** cho người dùng.

---

## Luồng xử lý lỗi

```
Exception phát sinh
        │
        ▼
Handler::resolveStatusCode()   ← map exception -> HTTP code
        │
        ├── request->expectsJson() ──► renderJson()  ← trả JSON chuẩn cho API/FE
        │                                (SCRUM-91 JSON schema)
        └── web request ──────────► renderWeb()      ← render Blade errors.show
                                        │
                                ErrorActionResolver::resolve()
                                        │
                               Trả title + message + primary/secondary action
```

### JSON response chuẩn (API)

```json
{
  "success": false,
  "error": {
    "status_code": 403,
    "title": "Bạn không có quyền truy cập",
    "message": "Tài khoản của bạn không đủ quyền...",
    "primary_action":   { "label": "Quay lại trang trước", "url": "..." },
    "secondary_action": { "label": "Về Dashboard",          "url": "..." }
  }
}
```

---

## Cấu trúc file

```
app/
├── Exceptions/
│   └── Handler.php                    ← Entry point – bắt & render mọi lỗi
│
├── Http/
│   ├── Controllers/
│   │   ├── Auth/LoginController.php   ← Đăng nhập / đăng xuất (Web)
│   │   ├── DashboardController.php    ← Trang tổng quan
│   │   ├── Admin/UserController.php   ← Quản lý user (cần quyền manage-users)
│   │   └── Api/
│   │       ├── AuthController.php     ← Login / Logout / Me (API Sanctum)
│   │       ├── CustomerController.php ← CRUD khách hàng (API)
│   │       └── CampaignController.php ← CRUD chiến dịch (API)
│   │
│   ├── Middleware/
│   │   └── CheckPermission.php        ← Ném AuthorizationException → 403
│   │
│   └── Requests/
│       ├── LoginRequest.php
│       ├── StoreCustomerRequest.php
│       ├── UpdateCustomerRequest.php
│       ├── StoreCampaignRequest.php
│       └── UpdateCampaignRequest.php
│
├── Models/
│   ├── User.php        ← role-based can(), relations
│   ├── Customer.php    ← SoftDeletes, assignedUser, campaigns
│   └── Campaign.php    ← SoftDeletes, creator, customer
│
└── Services/
    ├── AuthService.php          ← login/logout/currentUser/changePassword
    ├── CustomerService.php      ← CRUD + AuthZ check
    ├── CampaignService.php      ← CRUD + changeStatus + AuthZ check
    └── ErrorActionResolver.php  ← Xác định hành động gợi ý theo status code

config/
└── error-pages.php   ← Cấu hình tập trung: handled_codes, messages

database/
├── migrations/
│   ├── ..._create_users_table.php
│   ├── ..._create_customers_table.php
│   └── ..._create_campaigns_table.php
└── seeders/
    └── DatabaseSeeder.php   ← admin / manager / staff / inactive user

routes/
├── api.php           ← API routes (Sanctum)
└── web-example.php   ← Web routes mẫu

resources/views/errors/
├── layout.blade.php  ← Dark-mode glassmorphism layout
└── show.blade.php    ← Trang lỗi dùng chung
```

---

## Mã lỗi được xử lý

| Code | Trigger | Hành động gợi ý |
|------|---------|----------------|
| **401** | `AuthenticationException` | Đăng nhập lại |
| **403** | `AuthorizationException` / `CheckPermission` | Quay lại / Về Dashboard |
| **404** | `ModelNotFoundException` / route không tồn tại | Về trang chủ |
| **419** | `TokenMismatchException` (CSRF) | Tải lại trang |
| **500** | Mọi exception không xác định | Về trang chủ |

---

## Đăng ký middleware

Thêm vào `app/Http/Kernel.php`:

```php
protected $routeMiddleware = [
    // ...
    'permission' => \App\Http\Middleware\CheckPermission::class,
];
```

---

## Chạy migration & seed

```bash
php artisan migrate
php artisan db:seed
```

**Tài khoản mẫu:**

| Email | Password | Role |
|-------|----------|------|
| `admin@example.com`    | password | admin   |
| `manager@example.com`  | password | manager |
| `staff@example.com`    | password | staff   |
| `inactive@example.com` | password | *(bị khoá – test 401)* |

---

## Test nhanh

```bash
# Test 401 – chưa đăng nhập
curl -H "Accept: application/json" http://localhost/api/customers

# Test 403 – staff cố xóa customer
curl -X DELETE http://localhost/api/customers/1 \
  -H "Authorization: Bearer <staff_token>" \
  -H "Accept: application/json"

# Test 404
curl -H "Accept: application/json" http://localhost/api/customers/999
```
