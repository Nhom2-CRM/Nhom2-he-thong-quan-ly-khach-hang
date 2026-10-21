<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class LeadController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Lead::with('assignedAgent')->paginate(15));
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title'    => 'required|string|max:255',
            'region'   => 'nullable|string',
            'industry' => 'nullable|string',
            'notes'    => 'nullable|string',
        ]);

        $lead = Lead::create($validated);

        return response()->json(['message' => 'Tạo Lead thành công', 'data' => $lead], 201);
    }
}