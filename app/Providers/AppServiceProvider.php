<?php

namespace App\Providers;

use App\Models\Budget;
use App\Models\Expenses;
use App\Models\Income;
use App\Observers\BudgetObserver;
use App\Observers\ExpenseObserver;
use App\Observers\IncomeObserver;
use App\Observers\MonthlyReportObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Income::observe(IncomeObserver::class);
        Expenses::observe(ExpenseObserver::class);

        Income::observe(MonthlyReportObserver::class);
        Expenses::observe(MonthlyReportObserver::class);

        Expenses::observe(BudgetObserver::class);
        Budget::observe(BudgetObserver::class);
    }
}
