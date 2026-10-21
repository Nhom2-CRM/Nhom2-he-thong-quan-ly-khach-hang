<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\CreateActivityRequest;
use App\Http\Requests\Activity\UpdateActivityStatusRequest;
use App\Http\Resources\ActivityResource;
use App\Models\Activity;
use App\Services\ActivityService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ActivityController extends Controller
{
    public function __construct(
        protected ActivityService $activityService
    ) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $activities = $this->activityService->getUserActivities($request->user());

        return ActivityResource::collection($activities);
    }

    public function store(CreateActivityRequest $request): JsonResponse
    {
        $activity = $this->activityService->createActivity(
            $request->user(),
            $request->validated()
        );

        return response()->json([
            'message' => 'Công việc đã được tạo thành công.',
            'data' => new ActivityResource($activity),
        ], 201);
    }

    public function updateStatus(UpdateActivityStatusRequest $request, Activity $activity): JsonResponse
    {
        $this->authorize('updateStatus', $activity);

        $updated = $this->activityService->changeActivityStatus(
            $activity,
            $request->validated('status'),
            $request->validated('postpone_reason')
        );

        return response()->json([
            'message' => 'Cập nhật trạng thái công việc thành công.',
            'data' => new ActivityResource($updated),
        ]);
    }
}