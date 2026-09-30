# S1-05 Backend - Phân quyền theo vai trò và phạm vi dữ liệu

Laravel 13 + MySQL.

## Quy tắc phạm vi
- SALES_REP / MINE: chỉ dữ liệu do chính mình sở hữu.
- TEAM_LEADER / TEAM: dữ liệu cùng business_group_id.
- SALES_DIRECTOR / ALL: toàn bộ dữ liệu.

Áp dụng đồng nhất cho Customer, Opportunity, Activity, Quote; cả danh sách, tìm kiếm và xuất Excel.

## Chạy
1. `composer install`
2. copy `.env.example` thành `.env`, sửa mật khẩu MySQL.
3. `php artisan key:generate`
4. `php artisan migrate:fresh --seed`
5. `php artisan serve`
6. test: `php artisan test --filter=DataScopeTest`

Mật khẩu tài khoản seed: `12345678a`.
