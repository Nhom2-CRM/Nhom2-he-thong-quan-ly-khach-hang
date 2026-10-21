<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
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