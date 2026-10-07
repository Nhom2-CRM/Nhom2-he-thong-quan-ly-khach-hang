<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\SalesTeam;
use App\Models\PipelineStage;
use App\Models\Customer;
use App\Models\Opportunity;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Tạo cây nhóm kinh doanh đệ quy (S2-06)
        $parentTeam = SalesTeam::create(['name' => 'Khối Kinh Doanh Toàn Quốc']);
        $childTeam = SalesTeam::create([
            'name' => 'Nhóm Hà Nội',
            'parent_id' => $parentTeam->id,
        ]);

        // 2. Tạo User Quản lý (Team Cha) & User Sales Exec (Team Con)
        $manager = User::factory()->create([
            'name' => 'Trần Văn Quản Lý',
            'email' => 'manager@crm.com',
            'password' => bcrypt('password123'),
            'sales_team_id' => $parentTeam->id,
        ]);

        $salesExec = User::factory()->create([
            'name' => 'Nguyễn Văn Sales',
            'email' => 'sales@crm.com',
            'password' => bcrypt('password123'),
            'sales_team_id' => $childTeam->id,
        ]);

        // 3. Tạo Các giai đoạn Pipeline (S2-09)
        $stageNew = PipelineStage::create([
            'name' => 'Mới tiếp cận',
            'win_probability' => 10,
            'exit_requirements' => ['min_meetings' => 1],
        ]);

        $stageNegotiation = PipelineStage::create([
            'name' => 'Đàm phán hợp đồng',
            'win_probability' => 60,
            'exit_requirements' => null,
        ]);

        // 4. Tạo Customer mẫu cho Sales Exec
        $customer = Customer::create([
            'name' => 'Công ty TNHH Tập Đoàn ABC',
            'email' => 'contact@abcgroup.vn',
            'phone' => '0912345678',
            'user_id' => $salesExec->id,
            'sales_team_id' => $salesExec->sales_team_id,
        ]);

        // 5. Tạo Opportunity mẫu
        $opportunity = Opportunity::create([
            'title' => 'Hợp đồng tư vấn CRM cho ABC',
            'amount' => 100000000,
            'customer_id' => $customer->id,
            'user_id' => $salesExec->id,
            'sales_team_id' => $salesExec->sales_team_id,
            'stage_id' => $stageNew->id,
            'snapshot_win_probability' => $stageNew->win_probability,
        ]);

        // 6. Tạo Sanctum Token cho User Manager
        $token = $manager->createToken('test-api-token')->plainTextToken;

        $this->command->info('==================================================');
        $this->command->info('NẠP DỮ LIỆU MẪU THÀNH CÔNG!');
        $this->command->info('TOKEN DÙNG CHO THUNDER CLIENT / POSTMAN:');
        $this->command->warn($token);
        $this->command->info('==================================================');
    }
}