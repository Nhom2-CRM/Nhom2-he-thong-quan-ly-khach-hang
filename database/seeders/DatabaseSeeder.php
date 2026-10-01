<?php
namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder
{
 public function run(): void {
   User::updateOrCreate(['email'=>'admin@company.com'],['name'=>'Admin','password'=>'Admin1234','business_group'=>'Ban điều hành','role'=>'admin','status'=>'active','activated_at'=>now()]);
   User::updateOrCreate(['email'=>'sales1@company.com'],['name'=>'Nguyễn Minh Anh','password'=>'Sales1234','business_group'=>'Nhóm Kinh Doanh Miền Bắc','role'=>'sales','status'=>'active','activated_at'=>now()]);
   User::updateOrCreate(['email'=>'manager@company.com'],['name'=>'Trần Thu Hà','password'=>'Manager1234','business_group'=>'Nhóm Kinh Doanh Miền Bắc','role'=>'manager','status'=>'active','activated_at'=>now()]);
 }
}
