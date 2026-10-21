<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ContractController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Contract::with(['quotation', 'customer'])->paginate(15));
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'quotation_id'    => 'nullable|exists:quotations,id',
            'customer_id'     => 'required|exists:customers,id',
            'contract_number' => 'required|string|unique:contracts,contract_number',
            'value'           => 'required|numeric',
            'signed_date'     => 'nullable|date',
            'status'          => 'nullable|string',
        ]);

        $contract = Contract::create($validated);

        return response()->json(['message' => 'Tạo hợp đồng thành công', 'data' => $contract], 201);
    }
}