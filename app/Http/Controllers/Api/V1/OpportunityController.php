<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\OpportunityService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OpportunityController extends Controller
{
    public function __construct(
        protected OpportunityService $opportunityService
    ) {}

    /**
     * API Báo cáo dự báo doanh số cho Giám đốc kinh doanh[cite: 1]
     */
    public function forecastReport(Request $request): JsonResponse
    {
        $period = $request->query('period', 'this_month'); // this_month, next_month, this_quarter[cite: 1]
        $teamId = $request->query('team_id') ? (int)$request->query('team_id') : null; //[cite: 1]
        $userId = $request->query('user_id') ? (int)$request->query('user_id') : null; //[cite: 1]

        $data = $this->opportunityService->getSalesForecast($period, $teamId, $userId);

        return response()->json([
            'success' => true,
            'message' => 'Lấy dữ liệu dự báo doanh số thành công',
            'data' => $data,
        ]);
    }
}