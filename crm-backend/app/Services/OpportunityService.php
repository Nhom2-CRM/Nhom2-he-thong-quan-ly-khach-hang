<?php

namespace App\Services;

use App\Models\Opportunity;
use App\Models\PipelineStage;
use App\Models\Activity;
use Exception;

class OpportunityService
{
    /**
     * Chuyển giai đoạn Pipeline có kiểm tra điều kiện bắt buộc
     */
    public function changeStage(Opportunity $opportunity, int $newStageId): Opportunity
    {
        $currentStage = $opportunity->stage;
        $nextStage = PipelineStage::findOrFail($newStageId);

        // 1. Kiểm tra điều kiện rời stage hiện tại (VD: phải có ít nhất 1 cuộc gặp)
        if (!empty($currentStage->exit_requirements)) {
            $requirements = $currentStage->exit_requirements;
            
            if (isset($requirements['min_meetings'])) {
                $meetingCount = Activity::where('opportunity_id', $opportunity->id)
                    ->where('type', 'meeting')
                    ->count();

                if ($meetingCount < $requirements['min_meetings']) {
                    throw new Exception("Bắt buộc phải có ít nhất {$requirements['min_meetings']} cuộc gặp để rời giai đoạn này.");
                }
            }
        }

        // 2. Cập nhật sang Stage mới & lưu Snapshot xác suất thắng
        $opportunity->update([
            'stage_id' => $nextStage->id,
            'snapshot_win_probability' => $nextStage->win_probability,
        ]);

        return $opportunity;
    }

    /**
     * Tính dự báo doanh số = Amount * (Snapshot Win Probability / 100)
     */
    public function calculateForecast(Opportunity $opportunity): float
    {
        return $opportunity->amount * ($opportunity->snapshot_win_probability / 100);
    }
}