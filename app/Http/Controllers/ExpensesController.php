<?php

namespace App\Http\Controllers;

use App\Models\Expenses;
use Illuminate\Http\Request;

class ExpensesController extends Controller
{
    public function index()
    {
        return Expenses::all();
        return response()->json(Expenses::with('category')->get());
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

        $expenses = Expenses::create($request->all());

        return response()->json([
            'message' => 'Expense added successfully!',
            'data' => $expenses
        ], 201);
    }

    public function show($id)
    {
        $expenses = Expenses::with('category')->findOrFail($id);
        return response()->json($expenses);
    }

    public function update(Request $request, $id)
    {
        $expenses = Expenses::findOrFail($id);

        $request->validate([
            'category_id' => 'exists:categories,id',
            'amount' => 'numeric|min:1',
            'description' => 'nullable|string',
            'date' => 'required|date',
        ]);

        $expenses->update($request->all());

        return response()->json([
            'message' => 'Expense updated successfully!',
            'data' => $expenses
        ]);
    }

    public function destroy($id)
    {
        $expenses = Expenses::findOrFail($id);
        $expenses->delete();

        return response()->json([
            'message' => 'Expense deleted successfully!'
        ]);
    }
}
