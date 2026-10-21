<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Customer;
use App\Models\Lead;
use App\Enums\DataScopeEnum;
use App\Enums\LeadStatusEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
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
        ]);
    }
}