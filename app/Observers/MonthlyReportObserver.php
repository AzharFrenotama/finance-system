<?php

namespace App\Observers;

use App\Models\Expenses;
use App\Models\Income;
use App\Models\MonthlyReport;
use Illuminate\Database\Eloquent\Model;

class MonthlyReportObserver
{
    public function updateReport($model)
    {
        $month = date('m', strtotime($model->date));
        $year = date('Y', strtotime($model->date));

        $report = MonthlyReport::firstOrCreate([
            'profile_id' => $model->profile_id,
            'month' => $month,
            'year' => $year
        ]);

        $total_incomes = Income::where('profile_id', $model->profile_id)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->sum('amount');

        $total_expenses = Expenses::where('profile_id', $model->profile_id)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->sum('amount');

        $report->update([
            'total_incomes' => $total_incomes,
            'total_expenses' => $total_expenses,
            'balance' => $total_incomes - $total_expenses
        ]);
    }
    /**
     * Handle the MonthlyReport "created" event.
     */
    public function created($model): void
    {
        $this->updateReport($model);
    }

    /**
     * Handle the MonthlyReport "updated" event.
     */
    public function updated($model): void
    {
        $this->updateReport($model);
    }

    /**
     * Handle the MonthlyReport "deleted" event.
     */
    public function deleted($model): void
    {
        $this->updateReport($model);
    }

    /**
     * Handle the MonthlyReport "restored" event.
     */
    public function restored(MonthlyReport $monthlyReport): void
    {
        //
    }

    /**
     * Handle the MonthlyReport "force deleted" event.
     */
    public function forceDeleted(MonthlyReport $monthlyReport): void
    {
        //
    }
}
