<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Opportunity;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class OpportunityController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Opportunity::with(['customer', 'assignedAgent'])->paginate(15));
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'title'       => 'required|string|max:255',
            'amount'      => 'required|numeric',
            'stage'       => 'required|string',
            'close_date'  => 'nullable|date',
        ]);

        $opportunity = Opportunity::create($validated + ['assigned_to' => $request->user()?->id]);

        return response()->json(['message' => 'Tạo cơ hội kinh doanh thành công', 'data' => $opportunity], 201);
    }
}