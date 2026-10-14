<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Customer;
use App\Models\Contact;
use App\Models\Opportunity;
use App\Models\Activity;
use App\Models\Contract;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Tạo tài khoản Trưởng nhóm
        User::factory()->create([
            'name' => 'Trưởng Nhóm Sales',
            'email' => 'lead@example.com',
            'role' => 'team_lead',
        ]);

        // 2. Tạo 2 Khách hàng trùng lặp để test gộp dữ liệu[cite: 1]
        $customer1 = Customer::create([
            'name' => 'Công ty TNHH Công Nghệ ABC',
            'tax_code' => '0101234567',
            'website' => 'abc.com.vn',
        ]);

        $customer2 = Customer::create([
            'name' => 'Công ty Công Nghệ ABC Việt Nam',
            'tax_code' => '0101234567',
            'website' => 'abc.com',
        ]);

        // 3. Tạo dữ liệu liên hệ, cơ hội & hợp đồng
        Contact::create(['customer_id' => $customer1->id, 'name' => 'Nguyễn Văn A', 'phone' => '0901234567']);
        Contact::create(['customer_id' => $customer2->id, 'name' => 'Trần Thị B', 'phone' => '0987654321']);

        Opportunity::create(['customer_id' => $customer1->id, 'title' => 'Dự án CRM', 'amount' => 500000000, 'status' => 'open']);
        Opportunity::create(['customer_id' => $customer2->id, 'title' => 'Bảo trì hệ thống', 'amount' => 50000000, 'status' => 'open']);

        Contract::create(['customer_id' => $customer1->id, 'value' => 200000000, 'status' => 'signed']);

        // 4. Tạo 500 hoạt động để kiểm tra hiệu năng trang 360 (< 1.5s)[cite: 2]
        $activities = [];
        for ($i = 1; $i <= 500; $i++) {
            $activities[] = [
                'customer_id' => $customer1->id,
                'type' => 'call',
                'description' => "Ghi chú cuộc gọi tư vấn số $i",
                'created_at' => now()->subMinutes($i),
                'updated_at' => now()->subMinutes($i),
            ];
        }
        Activity::insert($activities);
    }
}