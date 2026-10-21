<?php

namespace App\Services;

use App\Models\Opportunity;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class OpportunityService
{
    /**
     * Lấy dự báo doanh số theo thời gian, nhân viên hoặc nhóm[cite: 1]
     */
    public function getSalesForecast(string $period = 'this_month', ?int $teamId = null, ?int $userId = null): array
    {
        $query = Opportunity::query();

        // 1. Lọc theo kỳ dự kiến chốt[cite: 1]
        $now = Carbon::now();
        match ($period) {
            'next_month' => $query->whereBetween('expected_close_date', [
                $now->copy()->addMonth()->startOfMonth(),
                $now->copy()->addMonth()->endOfMonth(),
            ]),
            'this_quarter' => $query->whereBetween('expected_close_date', [
                $now->copy()->startOfQuarter(),
                $now->copy()->endOfQuarter(),
            ]),
            default => $query->whereBetween('expected_close_date', [ // 'this_month'
                $now->copy()->startOfMonth(),
                $now->copy()->endOfMonth(),
            ]),
        };

        // 2. Lọc theo nhân viên hoặc nhóm[cite: 1]
        if ($teamId) {
            $query->where('team_id', $teamId);
        }
        if ($userId) {
            $query->where('user_id', $userId);
        }

        $opportunities = $query->get();

        // 3. Tính tổng dự báo trọng số = Sum(amount * probability / 100)[cite: 1]
        $weightedForecast = $opportunities->sum(function ($opp) {
            return $opp->amount * ($opp->probability / 100);
        });

        // 4. Doanh số thực tế đã chốt (trạng thái 'won')[cite: 1]
        $actualClosed = $opportunities->where('status', 'won')->sum('amount');

        // Chỉ tiêu mẫu (có thể lấy từ bảng targets)[cite: 1]
        $targetAmount = 500000000; 

        return [
            'period' => $period,
            'weighted_forecast' => round($weightedForecast, 2), // Tổng giá trị x xác suất[cite: 1]
            'actual_closed' => round($actualClosed, 2),          // Số đã chốt thực tế[cite: 1]
            'target_amount' => $targetAmount,                   // Chỉ tiêu[cite: 1]
            'gap_to_target' => round($targetAmount - $weightedForecast, 2),
            'total_opportunities' => $opportunities->count(),
        ];
    }
}