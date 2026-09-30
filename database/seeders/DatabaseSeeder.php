<?php
namespace Database\Seeders;
use App\Models\BusinessGroup;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $groups = collect(['Kinh doanh toàn hệ thống','Kinh doanh miền Bắc','Kinh doanh miền Nam'])
            ->mapWithKeys(fn($name) => [$name => BusinessGroup::firstOrCreate(['name'=>$name])]);
        $permissionMap = [
            'dashboard.view'=>'Xem tổng quan',
            'customers.view'=>'Xem khách hàng', 'customers.create'=>'Tạo khách hàng', 'customers.update'=>'Sửa khách hàng', 'customers.delete'=>'Xóa khách hàng',
            'campaigns.view'=>'Xem chiến dịch', 'campaigns.create'=>'Tạo chiến dịch', 'campaigns.update'=>'Sửa chiến dịch', 'campaigns.delete'=>'Xóa chiến dịch',
            'reports.view'=>'Xem báo cáo', 'users.manage'=>'Quản lý người dùng',
        ];
        $permissions = collect($permissionMap)->mapWithKeys(fn($name,$code)=>[$code=>Permission::firstOrCreate(['code'=>$code],['name'=>$name])]);
        $users = [
            ['name'=>'Nguyễn Văn Admin','email'=>'admin@example.com','role'=>'Quản trị viên','group'=>'Kinh doanh toàn hệ thống','perms'=>$permissions->keys()->all()],
            ['name'=>'Trần Minh Sales','email'=>'sales@example.com','role'=>'Nhân viên kinh doanh','group'=>'Kinh doanh miền Bắc','perms'=>['dashboard.view','customers.view','customers.create','campaigns.view']],
            ['name'=>'Lê Thu Viewer','email'=>'viewer@example.com','role'=>'Nhân viên xem báo cáo','group'=>'Kinh doanh miền Nam','perms'=>['dashboard.view','customers.view','reports.view']],
        ];
        foreach ($users as $data) {
            $user = User::updateOrCreate(['email'=>$data['email']], [
                'name'=>$data['name'], 'password'=>Hash::make('password'), 'role'=>$data['role'], 'business_group_id'=>$groups[$data['group']]->id,
            ]);
            $user->permissions()->sync(collect($data['perms'])->map(fn($code)=>$permissions[$code]->id)->all());
        }
        $this->call([CustomerSeeder::class, CampaignSeeder::class]);
    }
}
