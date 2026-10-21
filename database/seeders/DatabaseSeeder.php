<?php

namespace Database\Seeders;

use App\Models\Opportunity;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Tạo 1 user mẫu
        $user = User::factory()->create([
            'name' => 'Giám đốc kinh doanh',
            'email' => 'gdkd@example.com',
        ]);

        // Tạo 20 cơ hội bán hàng giả lập
        Opportunity::factory()->count(20)->create([
            'user_id' => $user->id,
        ]);
    }
}