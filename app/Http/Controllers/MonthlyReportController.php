<?php

namespace App\Http\Controllers;

use App\Models\MonthlyReport;
use Illuminate\Http\Request;

class MonthlyReportController extends Controller
{
    public function index(Request $request)
    {
        $reports = MonthlyReport::where('profile_id', $request->profile_id)
            ->orderByDesc('year')
            ->orderByDesc('month')
            ->get();

        return response()->json($reports);
    }

    public function show($id)
    {
        $report = MonthlyReport::findOrFail($id);
        return response()->json($report);
    }
}
