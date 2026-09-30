<?php

namespace Database\Seeders;

use App\Models\BusinessGroup;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Role::firstOrCreate(
            ['name' => 'admin'],
            ['display_name' => 'Quản trị hệ thống']
        );
        $leader = Role::firstOrCreate(
            ['name' => 'team_leader'],
            ['display_name' => 'Trưởng nhóm']
        );
        $staff = Role::firstOrCreate(
            ['name' => 'staff'],
            ['display_name' => 'Nhân viên']
        );

        $north = BusinessGroup::firstOrCreate(['name' => 'Nhóm Kinh Doanh Miền Bắc']);
        $south = BusinessGroup::firstOrCreate(['name' => 'Nhóm Kinh Doanh Miền Nam']);

        $adminUser = User::firstOrCreate(
            ['email' => 'admin@company.com'],
            ['name' => 'Quản trị viên', 'password' => 'Admin1234']
        );
        $adminUser->roles()->sync([$admin->id]);
        $adminUser->businessGroups()->sync([]);

        $leaderUser = User::firstOrCreate(
            ['email' => 'leader@company.com'],
            ['name' => 'Trưởng nhóm Miền Bắc', 'password' => 'Leader1234']
        );
        $leaderUser->roles()->sync([$leader->id, $staff->id]);
        $leaderUser->businessGroups()->sync([$north->id]);

        $staffUser = User::firstOrCreate(
            ['email' => 'staff@company.com'],
            ['name' => 'Nhân viên Miền Nam', 'password' => 'Staff1234']
        );
        $staffUser->roles()->sync([$staff->id]);
        $staffUser->businessGroups()->sync([$south->id]);
    }
}
