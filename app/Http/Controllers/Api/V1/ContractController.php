<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
<<<<<<< HEAD
use Illuminate\Http\Request;

class ContractController extends Controller
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
>>>>>>> 72f5237d663e404ee450fd532a2b229ee05201ee
