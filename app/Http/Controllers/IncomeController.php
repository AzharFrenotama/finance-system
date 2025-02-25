<?php

namespace App\Http\Controllers;

use App\Models\Income;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function index()
    {
        return Income::all();
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
    $incomes = Income::create($validated);
    return response()->json($incomes, 201);
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
    $incomes = Income::findOrFail($id);
    $incomes->update($validated);
    return response()->json($incomes);
    }

    public function destroy($id)
    {
    $incomes = Income::findOrFail($id);
    $incomes->delete();
    return response()->json(['message' => 'Incomes deleted
    successfully']);
    }
}
