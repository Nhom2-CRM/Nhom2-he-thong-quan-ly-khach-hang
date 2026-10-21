<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
<<<<<<< HEAD
<<<<<<< HEAD
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
=======
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ActivityController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Activity::with(['user', 'customer'])->paginate(15));
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'customer_id'  => 'nullable|exists:customers,id',
            'lead_id'      => 'nullable|exists:leads,id',
            'type'         => 'required|string',
            'description'  => 'required|string',
            'scheduled_at' => 'nullable|date',
        ]);

        $activity = Activity::create($validated + ['user_id' => $request->user()?->id]);

        return response()->json(['message' => 'Ghi nhận hoạt động thành công', 'data' => $activity], 201);
    }
}
>>>>>>> 72f5237d663e404ee450fd532a2b229ee05201ee
=======
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
>>>>>>> feature/S6-06-activity-backend
