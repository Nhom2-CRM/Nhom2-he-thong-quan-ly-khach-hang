<?php

namespace Tests\Feature\Api\V1;

use Tests\TestCase;
use App\Models\User;
use App\Models\Customer;
use App\Models\Activity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

class CustomerModuleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test 1: Kiểm tra API phát hiện khách hàng trùng lặp[cite: 1]
     */
    public function test_can_check_duplicate_customers(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        Customer::create([
            'name' => 'Công ty TNHH ABC',
            'tax_code' => '0101234567',
        ]);

        $response = $this->getJson('/api/v1/customers/check-duplicates?tax_code=0101234567');

        $response->assertStatus(200)
                 ->assertJsonCount(1, 'data');
    }

    /**
     * Test 2: Kiểm tra trang 360 tải 500 hoạt động dưới 1.5 giây[cite: 2]
     */
    public function test_customer_360_loads_under_1_5_seconds_with_500_activities(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $customer = Customer::create(['name' => 'Công ty Test Performance']);

        $activities = [];
        for ($i = 0; $i < 500; $i++) {
            $activities[] = [
                'customer_id' => $customer->id,
                'type' => 'call',
                'description' => "Hoạt động số {$i}",
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        Activity::insert($activities);

        $startTime = microtime(true);

        $response = $this->getJson("/api/v1/customers/{$customer->id}/360");

        $executionTime = microtime(true) - $startTime;

        $response->assertStatus(200);
        $this->assertLessThan(1.5, $executionTime, 'Trang 360 phản hồi vượt quá 1.5 giây');
    }

    /**
     * Test 3: Kiểm tra phân quyền gộp khách hàng[cite: 1]
     */
    public function test_rbac_authorization_for_customer_merging(): void
    {
        $staff = User::factory()->create(['role' => 'staff']);
        $teamLead = User::factory()->create(['role' => 'team_lead']);

        $master = Customer::create(['name' => 'Khách hàng A']);
        $duplicate = Customer::create(['name' => 'Khách hàng B']);

        // Staff gộp -> Bị chặn 403 Forbidden[cite: 1]
        Sanctum::actingAs($staff);
        $this->postJson('/api/v1/customers/merge', [
            'master_id' => $master->id,
            'duplicate_id' => $duplicate->id,
        ])->assertStatus(403);

        // Team Lead gộp -> Được phép 200 OK[cite: 1]
        Sanctum::actingAs($teamLead);
        $this->postJson('/api/v1/customers/merge', [
            'master_id' => $master->id,
            'duplicate_id' => $duplicate->id,
        ])->assertStatus(200);

        $this->assertDatabaseMissing('customers', ['id' => $duplicate->id]);
    }
}