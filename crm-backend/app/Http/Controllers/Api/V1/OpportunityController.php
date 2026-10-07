<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\OpportunityService;
use App\Models\Opportunity;
use Illuminate\Http\Request;

class OpportunityController extends Controller
{
    public function __construct(
        protected OpportunityService $opportunityService
    ) {}

    public function updateStage(Request $request, Opportunity $opportunity)
    {
        $request->validate([
            'stage_id' => ['required', 'exists:pipeline_stages,id'],
        ]);

        try {
            $updated = $this->opportunityService->changeStage($opportunity, $request->stage_id);
            
            return response()->json([
                'message' => 'Chuyển giai đoạn thành công',
                'opportunity' => $updated,
                'forecast' => $this->opportunityService->calculateForecast($updated)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 422);
        }
    }
}