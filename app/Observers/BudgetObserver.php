<?php

namespace App\Observers;

use App\Models\Budget;
use App\Models\Expenses;

class BudgetObserver
{
    /**
     * Handle the Budget "created" event.
     */
    public function created(Expenses $expenses): void
    {
        $budgets = Budget::where('category_id', $expenses->category_id)
            ->where('profile_id', $expenses->profile_id)
            ->where('month', date('m', strtotime($expenses->date)))
            ->where('year', date('Y', strtotime($expenses->date)))
            ->first();

        if ($budgets) {
            $budgets->current_expense += $expenses->amount;
            $budgets->save();

            if ($budgets->current_expense > $budgets->limit_amount) {
                // Kirim Notifikasi (Bisa pakai event atau sistem notifikasi Laravel)
                logger("⚠️ Peringatan: Pengeluaran telah melebihi batas untuk kategori: " . $budgets->category->name);
            }
        }
    }

    

    /**
     * Handle the Budget "updated" event.
     */
    public function updated(Budget $budget): void
    {
        //
    }

    /**
     * Handle the Budget "deleted" event.
     */
    public function deleted(Budget $budget): void
    {
        //
    }

    /**
     * Handle the Budget "restored" event.
     */
    public function restored(Budget $budget): void
    {
        //
    }

    /**
     * Handle the Budget "force deleted" event.
     */
    public function forceDeleted(Budget $budget): void
    {
        //
    }
}
