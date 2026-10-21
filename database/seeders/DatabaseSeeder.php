<?php

namespace Database\Seeders;

<<<<<<< HEAD
<<<<<<< HEAD
use App\Models\Opportunity;
use App\Models\User;
use Illuminate\Database\Seeder;
=======
use App\Models\User;
use App\Models\Customer;
use App\Models\Lead;
use App\Enums\DataScopeEnum;
use App\Enums\LeadStatusEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
>>>>>>> 72f5237d663e404ee450fd532a2b229ee05201ee

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
<<<<<<< HEAD
        // Tạo 1 user mẫu
        $user = User::factory()->create([
            'name' => 'Giám đốc kinh doanh',
            'email' => 'gdkd@example.com',
        ]);

        // Tạo 20 cơ hội bán hàng giả lập
        Opportunity::factory()->count(20)->create([
            'user_id' => $user->id,
=======
        // 1. Tạo Tài khoản Admin (Xem toàn bộ dữ liệu)
        $admin = User::create([
            'name'          => 'Admin CRM',
            'email'         => 'admin@crm.com',
            'password'      => Hash::make('password123'),
            'department_id' => 1,
            'data_scope'    => DataScopeEnum::ALL->value,
            'is_admin'      => true,
        ]);

        // 2. Tạo Tài khoản Nhân viên Sale (Chỉ xem dữ liệu cá nhân)
        $saleUser = User::create([
            'name'          => 'Nguyễn Văn Sale',
            'email'         => 'sale@crm.com',
            'password'      => Hash::make('password123'),
            'department_id' => 1,
            'data_scope'    => DataScopeEnum::PERSONAL->value,
            'is_admin'      => false,
        ]);

        // 3. Tạo Khách hàng mẫu
        Customer::create([
            'name'        => 'Công ty TNHH Công Nghệ ABC',
            'email'       => 'contact@abc.com',
            'phone'       => '0901234567',
            'tax_code'    => '0101234567',
            'address'     => 'Hà Nội, Việt Nam',
            'assigned_to' => $saleUser->id,
        ]);

        // 4. Tạo Lead mẫu
        Lead::create([
            'title'       => 'Khách hàng quan tâm giải pháp CRM',
            'region'      => 'Miền Bắc',
            'industry'    => 'Phần mềm / IT',
            'status'      => LeadStatusEnum::ASSIGNED->value,
            'assigned_to' => $saleUser->id,
            'notes'       => 'Cần báo giá trong tuần này.',
>>>>>>> 72f5237d663e404ee450fd532a2b229ee05201ee
        ]);
    }
}
=======
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
>>>>>>> feature/S6-06-activity-backend
