<?php
namespace Database\Seeders;

use App\Models\Activity;
use App\Models\BusinessGroup;
use App\Models\Customer;
use App\Models\Opportunity;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $groupA = BusinessGroup::create(['name' => 'Nhóm kinh doanh A']);
        $groupB = BusinessGroup::create(['name' => 'Nhóm kinh doanh B']);

        $director = User::create(['name'=>'Giám đốc','email'=>'director@company.com','password'=>Hash::make('12345678a'),'role'=>'SALES_DIRECTOR','data_scope'=>'ALL','business_group_id'=>$groupA->id]);
        $leader = User::create(['name'=>'Trưởng nhóm A','email'=>'leader@company.com','password'=>Hash::make('12345678a'),'role'=>'TEAM_LEADER','data_scope'=>'TEAM','business_group_id'=>$groupA->id]);
        $staffA = User::create(['name'=>'Nhân viên A','email'=>'staffa@company.com','password'=>Hash::make('12345678a'),'role'=>'SALES_REP','data_scope'=>'MINE','business_group_id'=>$groupA->id]);
        $staffB = User::create(['name'=>'Nhân viên B','email'=>'staffb@company.com','password'=>Hash::make('12345678a'),'role'=>'SALES_REP','data_scope'=>'MINE','business_group_id'=>$groupB->id]);

        foreach ([Customer::class, Opportunity::class, Activity::class, Quote::class] as $model) {
            $label = class_basename($model);
            $model::create(['name'=>"{$label} của A",'owner_id'=>$staffA->id,'business_group_id'=>$groupA->id,'status'=>'Đang xử lý','value'=>10000000,'description'=>'Dữ liệu thuộc nhân viên A']);
            $model::create(['name'=>"{$label} của B",'owner_id'=>$staffB->id,'business_group_id'=>$groupB->id,'status'=>'Mới','value'=>20000000,'description'=>'Dữ liệu thuộc nhân viên B']);
            $model::create(['name'=>"{$label} của trưởng nhóm",'owner_id'=>$leader->id,'business_group_id'=>$groupA->id,'status'=>'Đang xử lý','value'=>30000000,'description'=>'Dữ liệu thuộc nhóm A']);
        }
    }
}
