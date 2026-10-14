<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Contact;
use App\Models\Opportunity;
use App\Models\Activity;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

readonly class CustomerService
{
    /**
     * Phát hiện trùng lặp theo Mã số thuế, Tên công ty gần đúng và Website[cite: 1]
     */
    public function findDuplicates(?string $taxCode, ?string $name, ?string $website): Collection
    {
        return Customer::query()
            ->when($taxCode, fn($q) => $q->orWhere('tax_code', $taxCode))
            ->when($website, fn($q) => $q->orWhere('website', 'LIKE', "%{$website}%"))
            ->when($name, fn($q) => $q->orWhere('name', 'LIKE', "%{$name}%"))
            ->select(['id', 'name', 'tax_code', 'website', 'created_at'])
            ->limit(10)
            ->get();
    }

    /**
     * Tải dữ liệu trang 360 dưới 1,5 giây với 500 hoạt động[cite: 2]
     */
    public function getCustomer360Data(Customer $customer): Customer
    {
        return $customer->load([
            'contacts:id,customer_id,name,phone,email',
            'opportunities' => fn($q) => $q->select('id', 'customer_id', 'title', 'amount', 'status'),
            'activities' => fn($q) => $q->select('id', 'customer_id', 'type', 'description', 'created_at')
                                       ->latest('created_at')
                                       ->take(500),
        ])
        ->loadSum(['contracts as total_signed_value' => fn($q) => $q->where('status', 'signed')], 'value')
        ->loadSum(['opportunities as open_opportunity_value' => fn($q) => $q->where('status', 'open')], 'amount');
    }

    /**
     * Gộp khách hàng: giữ lại toàn bộ người liên hệ, cơ hội và hoạt động của cả hai bản ghi[cite: 1]
     */
    public function mergeCustomers(int $masterId, int $duplicateId): void
    {
        DB::transaction(function () use ($masterId, $duplicateId) {
            Contact::where('customer_id', $duplicateId)->update(['customer_id' => $masterId]);
            Opportunity::where('customer_id', $duplicateId)->update(['customer_id' => $masterId]);
            Activity::where('customer_id', $duplicateId)->update(['customer_id' => $masterId]);

            Customer::where('id', $duplicateId)->delete();
        });
    }
}