<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
<<<<<<< HEAD
use Illuminate\Http\Request;

class QuotationController extends Controller
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
use App\Models\Quotation;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class QuotationController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Quotation::with(['opportunity', 'customer'])->paginate(15));
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'opportunity_id' => 'required|exists:opportunities,id',
            'customer_id'    => 'required|exists:customers,id',
            'code'           => 'required|string|unique:quotations,code',
            'total_amount'   => 'required|numeric',
            'status'         => 'nullable|string',
        ]);

        $quotation = Quotation::create($validated);

        return response()->json(['message' => 'Tạo báo giá thành công', 'data' => $quotation], 201);
    }
}
>>>>>>> 72f5237d663e404ee450fd532a2b229ee05201ee
