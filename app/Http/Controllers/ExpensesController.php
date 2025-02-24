<?php

namespace App\Http\Controllers;

use App\Models\Expenses;
use Illuminate\Http\Request;

class ExpensesController extends Controller
{
    public function index()
    {
        return Expenses::all();
    }

    public function store(Request $request)
    {
    $validated = $request->validate([
        'profile_id' => 'required|exists:profiles,id',
        'amount' => 'required|numeric|min:0',
        'category' => 'required|string|max:255',
        'description' => 'nullable|string',
        'date' => 'required|date',
    ]);
    $expenses = Expenses::create($validated);
    return response()->json($expenses, 201);
    }  

    public function update(Request $request, $id)
    {
    $validated = $request->validate([
        'profile_id' => 'required|exists:profiles,id',
        'amount' => 'required|numeric|min:0',
        'category' => 'required|string|max:255',
        'description' => 'nullable|string',
        'date' => 'required|date',
    ]);
    $expenses = Expenses::findOrFail($id);
    $expenses->update($validated);
    return response()->json($expenses);
    }

    public function destroy($id)
    {
    $expenses = Expenses::findOrFail($id);
    $expenses->delete();
    return response()->json(['message' => 'Expenses deleted
    successfully']);
    }
}
