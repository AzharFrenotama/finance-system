<?php

namespace App\Http\Controllers;

use App\Models\Income;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function index()
    {
        return Income::all();
        return response()->json(Income::with('category')->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'profile_id' => 'required|exists:profiles,id',
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:1',
            'description' => 'nullable|string',
            'date' => 'required|date',
        ]);

        $incomes = Income::create($request->all());

        return response()->json([
            'message' => 'Expense added successfully!',
            'data' => $incomes
        ], 201);
    }

    public function show($id)
    {
        $incomes = Income::with('category')->findOrFail($id);
        return response()->json($incomes);
    }

    public function update(Request $request, $id)
    {
        $incomes = Income::findOrFail($id);

        $request->validate([
            'category_id' => 'exists:categories,id',
            'amount' => 'numeric|min:1',
            'description' => 'nullable|string'
            
        ]);

        $incomes->update($request->all());

        return response()->json([
            'message' => 'Income updated successfully!',
            'data' => $incomes
        ]);
    }

    public function destroy($id)
    {
        $incomes = Income::findOrFail($id);
        $incomes->delete();

        return response()->json([
            'message' => 'Income deleted successfully!'
        ]);
    }
}
