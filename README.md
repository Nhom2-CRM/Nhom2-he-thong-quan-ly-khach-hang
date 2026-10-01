# S1-08 - Quản lý tài khoản người dùng
Laravel 13 + MySQL. Đăng nhập dùng `session_token` tương thích các Sprint trước.

## Chạy
1. `composer install`
2. `copy .env.example .env` và điền DB_PASSWORD
3. `php artisan key:generate`
4. `php artisan migrate --seed`
5. `php artisan serve`

Mặc định mail dùng `MAIL_MAILER=log`, nội dung email nằm trong `storage/logs/laravel.log`. Muốn gửi mail thật hãy cấu hình SMTP trong `.env`.

Tài khoản demo: `admin@company.com / Admin1234`.
