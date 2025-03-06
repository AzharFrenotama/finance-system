<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $budgets = Budget::with(['profile', 'category'])->get();
        return response()->json($budgets);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'profile_id' => 'required|exists:profiles,id',
            'category_id' => 'required|exists:categories,id',
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2000',
            'limit_amount' => 'required|numeric|min:0',
        ]);

        $budgets = Budget::create([
            'profile_id' => $request->profile_id,
            'category_id' => $request->category_id,
            'month' => $request->month,
            'year' => $request->year,
            'limit_amount' => $request->limit_amount,
            'current_expense' => 0
        ]);

        return response()->json([
            'message' => 'Budget created successfully!',
            'data' => $budgets
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $budgets = Budget::with(['profile', 'category'])->findOrFail($id);
        return response()->json($budgets);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $budgets = Budget::findOrFail($id);
        $budgets->update($request->all());

        return response()->json([
            'message' => 'Budget updated successfully!',
            'data' => $budgets
        ]);    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $budgets = Budget::findOrFail($id);
        $budgets->delete();

        return response()->json(['message' => 'Budget deleted successfully!']);
    }
}
