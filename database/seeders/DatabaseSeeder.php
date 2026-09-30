<?php

namespace Database\Seeders;

use App\Models\Campaign;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── 1. Tạo users ──────────────────────────────────────────────────────
        $admin = User::create([
            'name'      => 'Admin',
            'email'     => 'admin@example.com',
            'password'  => Hash::make('password'),
            'role'      => 'admin',
            'is_active' => true,
        ]);

        $manager = User::create([
            'name'      => 'Nguyễn Văn Manager',
            'email'     => 'manager@example.com',
            'password'  => Hash::make('password'),
            'role'      => 'manager',
            'is_active' => true,
        ]);

        $staff = User::create([
            'name'      => 'Trần Thị Staff',
            'email'     => 'staff@example.com',
            'password'  => Hash::make('password'),
            'role'      => 'staff',
            'is_active' => true,
        ]);

        // Tài khoản bị vô hiệu hoá – dùng để test lỗi 401
        User::create([
            'name'      => 'Inactive User',
            'email'     => 'inactive@example.com',
            'password'  => Hash::make('password'),
            'role'      => 'staff',
            'is_active' => false,
        ]);

        // ── 2. Tạo customers ──────────────────────────────────────────────────
        $customers = [
            ['name' => 'Công ty ABC',      'email' => 'abc@company.vn',    'status' => 'active',   'assigned_to' => $staff->id],
            ['name' => 'Công ty XYZ',      'email' => 'xyz@company.vn',    'status' => 'prospect', 'assigned_to' => $staff->id],
            ['name' => 'Nguyễn Văn Khách', 'email' => 'khach1@gmail.com',  'status' => 'lead',     'assigned_to' => $manager->id],
            ['name' => 'Trần Thị B',       'email' => 'tranb@gmail.com',   'status' => 'inactive', 'assigned_to' => $staff->id],
            ['name' => 'CTCP Delta',       'email' => 'delta@corp.vn',     'status' => 'active',   'assigned_to' => $manager->id],
        ];

        foreach ($customers as $data) {
            Customer::create(array_merge($data, [
                'phone'   => '090' . rand(1000000, 9999999),
                'company' => $data['name'],
            ]));
        }

        // ── 3. Tạo campaigns ──────────────────────────────────────────────────
        $campaigns = [
            ['name' => 'Campaign Q1 2025', 'status' => 'completed', 'budget' => 50_000_000],
            ['name' => 'Email Marketing',  'status' => 'active',    'budget' => 20_000_000],
            ['name' => 'Zalo OA Outreach', 'status' => 'active',    'budget' => 15_000_000],
            ['name' => 'Draft Campaign',   'status' => 'draft',     'budget' => null],
        ];

        foreach ($campaigns as $data) {
            Campaign::create(array_merge($data, [
                'created_by' => $admin->id,
                'starts_at'  => now()->subDays(rand(10, 60)),
                'ends_at'    => now()->addDays(rand(10, 90)),
            ]));
        }
    }
}
