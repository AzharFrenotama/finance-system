<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return Profile::all();
    }

    public function store(Request $request)
    {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6',
        'balance' => 'numeric|min:0',
        'role' => 'in:user,admin',
    ]);
    $profiles = Profile::create($validated);
    return response()->json($profiles, 201);
    }  

    public function update(Request $request, $id)
    {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6',
        'balance' => 'numeric|min:0',
        'role' => 'in:user,admin',
    ]);
    $profiles = Profile::findOrFail($id);
    $profiles->update($validated);
    return response()->json($profiles);
    }

    public function destroy($id)
    {
    $profiles = Profile::findOrFail($id);
    $profiles->delete();
    return response()->json(['message' => 'Profile deleted
    successfully']);
    }
}
